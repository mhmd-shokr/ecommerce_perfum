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
        return Product::with(['category','brand','sizes','fragranceNotes','stockMovements'])->paginate($perPage);
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
            ->first();
    }

    public function findBySlugExceptId(string $slug,int $id){
        return Product::where('slug',$slug)->where('id','!=',$id)->first();
    }
    
    public function filterProducts(array $filters)
    {
        $query = Product::query()->with(['category', 'brand'])->where('status', 1);
    
        // Search
        if (!empty($filters['search'])) {
            $search = $filters['search'];
    
            $query->where(function ($q) use ($search) {
                $q->where('name->en', 'like', "%{$search}%")
                  ->orWhere('name->ar', 'like', "%{$search}%");
            });
        }
    
        // Category
        if (!empty(array_filter((array) ($filters['category'] ?? [])))) {
            $query->whereIn('category_id', (array) $filters['category']);
        }
    
        // Brand
        if (!empty(array_filter((array) ($filters['brand'] ?? [])))) {
            $query->whereIn('brand_id', (array) $filters['brand']);
        }
    
        // Price Range (FIXED)
        $min = $filters['min_price'] ?? null;
        $max = $filters['max_price'] ?? null;
    
        if (($min !== null && $min !== '') && ($max !== null && $max !== '')) {
    
            $min = (float) $min;
            $max = (float) $max;
    
            // swap if invalid range
            if ($min > $max) {
                [$min, $max] = [$max, $min];
            }
    
            $query->whereBetween('price', [$min, $max]);
    
        } else {
            if ($min !== null && $min !== '') {
                $query->where('price', '>=', (float) $min);
            }
    
            if ($max !== null && $max !== '') {
                $query->where('price', '<=', (float) $max);
            }
        }
    
        // In Stock (FIXED)
        if (isset($filters['in_stock']) && $filters['in_stock'] == 1) {
            $query->where('is_out_of_stock', 0);
        }
    
        // On Sale
        if (!empty($filters['on_sale'])) {
            $query->whereNotNull('sale_price');
        }
    
        // New
        if (!empty($filters['is_new'])) {
            $query->where('created_at', '>=', now()->subDays(7));
        }
    
        // Sort
        switch ($filters['sort'] ?? null) {
    
            case 'price_asc':
                $query->orderBy('price');
                break;
    
            case 'price_desc':
                $query->orderByDesc('price');
                break;
    
            case 'top_rated':
                $query->withAvg([
                    'reviews as average_rating' => function ($q) {
                        $q->where('is_approved', 1);
                    }
                ], 'rating');
    
                $query->orderByDesc('average_rating');
                break;
    
            default:
                $query->latest();
        }
    
        return $query->paginate(12)->withQueryString();
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