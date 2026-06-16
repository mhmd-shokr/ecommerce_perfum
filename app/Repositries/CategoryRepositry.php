<?php
namespace App\Repositries;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Override;

class CategoryRepositry implements CategoryInterface{

    
    public function all(){
        $categories=Category::latest()->get();
        return $categories;
    }

    public function find(int $id){
        return Category::find($id);
    }
    public function findOrFail(int $id){
        $category=Category::findOrFail($id);
        return $category;
    }
    
    public function create(array $data){
        return Category::create($data);
    }

    public function update(int $id,array $data){
        $category=Category::findOrFail($id);
        $category->update($data);
        return $category;
    }


    public function delete(int $id){
        $category=Category::findOrFail($id);
        return $category->delete();
    }

    public function count(){
        $categoryCount=Category::count();
        return $categoryCount;
    } public function getRoots(): Collection
    {
        $roots=Category::whereNull('parent_id')->with('children')->get();
        return $roots;
    }

    public function getAllWithChildren(): Collection
    {
        $categoryWithChildren=Category::with('children')->get();
        return $categoryWithChildren;
    }

    public function getCategoryDistribution(): Collection
    {
        $categoryDistribution=Category ::withCount('products')->orderByDesc('products_count')->get();
        return $categoryDistribution;
    }

    public function getPaginateCategories(int $perPage = 10)
    {
        $paginated=Category::withCount('products')->latest()->paginate($perPage);
        return $paginated;
    }

}