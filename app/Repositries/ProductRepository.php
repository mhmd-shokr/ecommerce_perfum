<?php 
namespace App\Repositries;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Override;

class ProductRepository implements ProductInterface{

    public function all(){
        return Product::latest()->get();
    }

    public function find($id){
        return Product::find($id);
    }
    public function findOrFail($id){
        return Product::findOrFail($id);
    }


    public function create(array $data){
        return Product::create($data);
    }

    public function update(int $id,array $data){
        $product=Product::findOrFail($id);
        return $product->update($data);
    }

    public function delete(int $id){
        $product=Product::findOrFail($id);
        return $product->delete();
    }

    public function count(){
        return Product::count();
    }

    public function getByCategory(int $categoryId){
        return Product::where('category_id',$categoryId)->get();
    }
    
    public function getActiveWithRelations()
    {
        return Product::with(['category','brand','sizes','fragranceNotes','stockMovements'])
        ->latest()->get();
    }

    public function getPaginatedActiveWithRelations(int $perPage=10){
        return Product::where('status',1)->with(['category','brand','sizes','fragranceNotes','stockMovements'])->paginate($perPage);
    }
    public function findWithRelations(int $id){
        return Product::with([
            'category', 
            'brand', 
            'sizes', 
            'fragranceNotes', 
            'stockMovements',
            'reviews'=>function($query){
                $query->where('is_approved', 1)->with('user')->latest();
            }
        ])->withAvg([
            'reviews as average_rating'=>function($query){
                $query->where('is_approved',1);
            }
        ],'rating')->withCount([
            'reviews'=>function($query){
                $query->where('is_approved',1);
            }
        ])->findOrFail($id);
    }
    
   

    public function getRelatedProducts(Product $product){
        return Product::where('category_id',$product->category_id)->whereKeyNot($product->id)
        ->take(4)->get();
    }

    public function countActive(){
        return Product::where('status',1)->count();
    }

    public function findBySlug(string $slug)
    {
        return Product::with(['category', 'brand', 'sizes', 'fragranceNotes','reviews'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function findBySlugExceptId(string $slug,int $id){
        return Product::where('slug',$slug)->where('id','!=',$id)->first();
    }
    
    public function filterProducts(array $filters=[],int $perPage=10,bool $isAdmin=false)
    {
        // $query = Product::query()->with(['category', 'brand'])->where('status', 1);
    
        // // Search
        // if (!empty($filters['search'])) {
        //     $search = $filters['search'];
    
        //     $query->where(function ($q) use ($search) {
        //         $q->where('name->en', 'like', "%{$search}%")
        //           ->orWhere('name->ar', 'like', "%{$search}%");
        //     });
        // }
    
        // // Category
        // if (!empty(array_filter((array) ($filters['category'] ?? [])))) {
        //     $query->whereIn('category_id', (array) $filters['category']);
        // }
    
        // // Brand
        // if (!empty(array_filter((array) ($filters['brand'] ?? [])))) {
        //     $query->whereIn('brand_id', (array) $filters['brand']);
        // }
    
        // // Price Range (FIXED)
        // $min = $filters['min_price'] ?? null;
        // $max = $filters['max_price'] ?? null;
    
        // if (($min !== null && $min !== '') && ($max !== null && $max !== '')) {
    
        //     $min = (float) $min;
        //     $max = (float) $max;
    
        //     // swap if invalid range
        //     if ($min > $max) {
        //         [$min, $max] = [$max, $min];
        //     }
    
        //     $query->whereBetween('price', [$min, $max]);
    
        // } else {
        //     if ($min !== null && $min !== '') {
        //         $query->where('price', '>=', (float) $min);
        //     }
    
        //     if ($max !== null && $max !== '') {
        //         $query->where('price', '<=', (float) $max);
        //     }
        // }
    
        // // In Stock (FIXED)
        // if (isset($filters['in_stock']) && $filters['in_stock'] == 1) {
        //     $query->where('is_out_of_stock', 0);
        // }
    
        // // On Sale
        // if (!empty($filters['on_sale'])) {
        //     $query->whereNotNull('sale_price');
        // }
    
        // // New
        // if (!empty($filters['is_new'])) {
        //     $query->where('created_at', '>=', now()->subDays(7));
        // }
    
        // // Sort
        // switch ($filters['sort'] ?? null) {
    
        //     case 'price_asc':
        //         $query->orderBy('price');
        //         break;
    
        //     case 'price_desc':
        //         $query->orderByDesc('price');
        //         break;
    
        //     case 'top_rated':
        //         $query->withAvg([
        //             'reviews as average_rating' => function ($q) {
        //                 $q->where('is_approved', 1);
        //             }
        //         ], 'rating');
    
        //         $query->orderByDesc('average_rating');
        //         break;
    
        //     default:
        //         $query->latest();
        // }
    
        // return $query->paginate($perPage)->withQueryString();

        $allowedSorts = [
            'price',
            'name',
            'created_at',
            'stock_quantity'
        ];
    
        return Product::query()
            ->with(['category', 'brand'])

            // Status for customer
            ->when(!$isAdmin,fn($query)=>$query->where('status',1))
            // Status for admin
            ->when($isAdmin&&
                array_key_exists('status', $filters),
                fn($query) =>
                    $query->where('status', $filters['status'])
            )
    
            // Search
            ->when(
                $filters['search'] ?? null,
                fn($query, $search) =>
                    $query->where(function ($q) use ($search) {
                        $q->where('name->en', 'like', "%{$search}%")
                            ->orWhere('name->ar', 'like', "%{$search}%")
                            ->orWhere('sku', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%");
                    })
            )
    
            // Category
            ->when(
                $filters['category'] ?? null,
                fn($query, $category) =>
                    $query->whereIn('category_id', (array) $category)
            )
    
            // Brand
            ->when(
                $filters['brand'] ?? null,
                fn($query, $brand) =>
                    $query->whereIn('brand_id', (array) $brand)
            )
    
            // Featured
            ->when(
                array_key_exists('featured', $filters),
                fn($query) =>
                    $query->where('is_featured', $filters['featured'])
            )
    
            // Price Min
            ->when(
                isset($filters['min_price']) && $filters['min_price'] !== '',
                fn($query) =>
                    $query->where('price', '>=', (float) $filters['min_price'])
            )
    
            // Price Max
            ->when(
                isset($filters['max_price']) && $filters['max_price'] !== '',
                fn($query) =>
                    $query->where('price', '<=', (float) $filters['max_price'])
            )
    
            // In Stock
            ->when(
                isset($filters['in_stock']) && $filters['in_stock'] == 1,
                fn($query) =>
                    $query->where('is_out_of_stock', 0)
            )
    
            // On Sale
            ->when(
                !empty($filters['on_sale']),
                fn($query) =>
                    $query->whereNotNull('sale_price')
            )
    
            // New Products (last 7 days)
            ->when(
                !empty($filters['is_new']),
                fn($query) =>
                    $query->where('created_at', '>=', now()->subDays(7))
            )
    
            // Sorting
            ->when(
                $filters['sort'] ?? null,
                function ($query, string $sort) use ($allowedSorts) {
                    
                    //top rated
                    if($sort ==='top_rated'){
                        $query->whereHas('reviews', function($q){
                            $q->where('is_approved',1);
                        })
                        ->withAvg(['reviews as average_rating'=>function($q){
                            $q->where('is_approved',1);
                        }
                    ],'rating')->orderByDesc('average_rating');
                    return $query;
                    }
                    $direction = str_starts_with($sort, '-') 
                        ? 'desc' 
                        : 'asc';
    
                    $column = ltrim($sort, '-');
    
                    if (in_array($column, $allowedSorts)) {
                        $query->orderBy($column, $direction);
                    }
                },
                fn($query) =>
                    $query->latest()
            )
    
            ->paginate($perPage)
            ->withQueryString();
    }

    public function lowStockProducts()
    {
        return Product::whereColumn(
            'stock_quantity',
            '<=',
            'low_stock_threshold'
        )->count();
    }
}