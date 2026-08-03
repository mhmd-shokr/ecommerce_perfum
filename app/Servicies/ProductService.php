<?php
namespace App\Servicies;
use App\Helpers\CacheHelper;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Servicies\StockService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService{
    protected $repository;
    protected $stockService;
    public function __construct(ProductInterface $repository,StockService $stockService)
    {
        $this->repository = $repository;
        $this->stockService = $stockService;
    }

    public function getProducts(){
        return $this->repository->getActiveWithRelations();
    }

    public function getAdminProduct(Product $product): Product
{
    return Cache::remember(
        "admin.product.{$product->id}",
        now()->addMinutes(30),
        fn () => $this->repository->findWithRelations($product->id)
    );
}
    public function getPublicProduct(string $slug){
        return Cache::remember(
            "customer.product.{$slug}",
            now()->addMinutes(30),
            fn () => $this->repository->findBySlug($slug)
        );
    }
    public function getPaginatedProducts(array $filters=[] ,int $perPage = 10,  bool $isAdmin=false)
    {
        $cacheKey='products.'.md5(json_encode([
            'filters'=>$filters,
            'page'=>request('page',1),
            'per_page'=>$perPage,
            'locale'=>app()->getLocale(),
            'admin'=>$isAdmin
        ]));
        return Cache::remember($cacheKey
        ,now()->addMinutes(30)
        ,fn()=>$this->repository->filterProducts($filters,$perPage,$isAdmin)) ;
    }
    public function getProductById($id){
        return $this->repository->findWithRelations($id);
    }

    public function createProduct(array $data)
    {
        // Generate slug
        if (isset($data['name']['en'])) {
            $slug = Str::slug($data['name']['en']);
            $original = $slug;
            $count = 1;
            while ($this->repository->findBySlug($slug)) {
                $slug = $original . '-' . $count++;
            }
            $data['slug'] = $slug;
        }
    
        if (request()->hasFile('images')) {
            $data['images'] = request()->file('images')->store('products', 'public');
        }
        $stockQty = $data['stock_quantity'] ?? 0;
        unset($data['stock_quantity']);
        $product = DB::transaction(function() use($stockQty,$data){
            $product = $this->repository->create($data);
    
            if ($stockQty > 0) {
                $this->stockService->increase($product, $stockQty, 'opening stock');
            }
            return $product->fresh();
        });
        CacheHelper::clearProductCaches($product); 
        return $product;
    }
    
    public function updateProduct(Product $product, array $data)
    {
        $product = $this->repository->findWithRelations($product->id);
    
        // Generate slug
        if (isset($data['name']['en'])) {
            $slug = Str::slug($data['name']['en']);
            $original = $slug;
            $count = 1;
            while ($this->repository->findBySlugExceptId($slug, $product->id)) {
                $slug = $original . '-' . $count++;
            }
            $data['slug'] = $slug;
        }
    
        
    
        DB::transaction(function() use($product,$data){
            // Handle stock adjustment
        if (isset($data['stock_quantity'])) {
            $currentStock = $product->stock_quantity ?? 0;
            $diff = $data['stock_quantity'] - $currentStock;            if ($diff > 0) {
                $this->stockService->increase($product, $diff, 'manual adjustment');
            } elseif ($diff < 0) {
                $this->stockService->decrease($product, abs($diff), 'manual adjustment');
            }
            unset($data['stock_quantity']);
        }

        
        if (request()->hasFile('images')) {
            if ($product->images && Storage::disk('public')->exists($product->images)) {
                Storage::disk('public')->delete($product->images);
            }
            $data['images'] = request()->file('images')->store('products', 'public');
        } else {
            unset($data['images']);
        }
    

        $this->repository->update($product->id, $data);

        });
        CacheHelper::clearProductCaches($product); 
        return $this->repository->findWithRelations($product->id)->fresh();
    }


    
    
    public function deleteProduct(int $id): bool
    {
        $product = $this->repository->find($id);
    
        if (! $product) {
            return false;
        }
    
        $deleted = $this->repository->delete($id);
    
        if ($deleted) {
            CacheHelper::clearProductCaches($product);    

        }
    
        return $deleted;
    }
    
    public function getProductBySlug(string $slug){
        return Cache::remember("product.$slug",now()->addMinutes(30),
        fn()=>$this->repository->findBySlug($slug)) ;
    }

    public function getRelatedProduct(Product $product){
        return Cache::remember("product.related.{$product->id}",now()->addMinutes(30),
        fn()=> $this->repository->getRelatedProducts($product));
    }

    public function filterProducts(
        array $filters = [],
        int $perPage = 10,
        bool $isAdmin = false
    )
    {
        return $this->repository
            ->filterProducts(
                $filters,
                $perPage,
                $isAdmin
            );
    }
}