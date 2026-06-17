<?php
namespace App\Servicies;
use App\Interfaces\ProductInterface;
use App\Servicies\StockService;
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

    public function getPaginatedProducts(int $perPage = 10)
    {
        return $this->repository->getPaginatedActiveWithRelations($perPage);
    }
    public function geyProductById($id){
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
    
        $product = $this->repository->create($data);
    
        if ($stockQty > 0) {
            $this->stockService->increase($product, $stockQty, 'opening stock');
        }
    
        return $product;
    }
    
    public function updateProduct(int $id, array $data)
    {
        $product = $this->repository->findWithRelations($id);
    
        // Generate slug
        if (isset($data['name']['en'])) {
            $slug = Str::slug($data['name']['en']);
            $original = $slug;
            $count = 1;
            while ($this->repository->findBySlugExceptId($slug, $id)) {
                $slug = $original . '-' . $count++;
            }
            $data['slug'] = $slug;
        }
    
        // Handle stock adjustment
        if (isset($data['stock_quantity'])) {
            $diff = $data['stock_quantity'] - $product->stock_quantity;
            if ($diff > 0) {
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
    
        $this->repository->update($id, $data);
    
        return $this->repository->findWithRelations($id);
    }
    
    
    public function deleteProduct(int $id): bool
    {
        return $this->repository->delete($id);
    }
    

}