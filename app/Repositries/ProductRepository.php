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
    
    //orders
    // public function getTopSelling(int $count = 5)
    // {
    // }


    public function countActive(){
        return Product::where('status',1)->count();
    }

    public function findBySlug(string $slug){
        return Product::where('slug',$slug)->first();
    }

    public function findBySlugExceptId(string $slug,int $id){
        return Product::where('slug',$slug)->where('id','!=',$id)->first();
    }
}