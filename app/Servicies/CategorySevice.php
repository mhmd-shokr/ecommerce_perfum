<?php
namespace App\Servicies;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySevice{
    public function __construct(protected CategoryInterface $repository){}

    public function getCategories(){
        return $this->repository->getPaginateCategories();
    }

    public function getAllCategories($perPage){
        return $this->repository->getPaginateCategories($perPage);
    }

    public function getCategoryById(int $id){
        return $this->repository->findOrFail($id);
    }

    public function getRootsCategory(){
        return $this->repository->getRoots();
    }

    public function getAllWithChildren(){
        return $this->repository->getAllWithChildren();
    }
    public function createCategory(array $data){

        if(isset($data['name']['en'])){
            $data['slug']=Str::slug($data['name']['en']);

        }

        if(isset($data['images'])){
            $data['images'] = $data['images']
                ->store('categories', 'public');
        }
        $data['status']=$data['status'] ??0;
        return $this->repository->create($data);
    }

    public function updateCategory(int $id , array $data){

        
        $category=$this->repository->findOrFail($id);

        if(isset($data['name']['en'])){
            $data['slug']=Str::slug($data['name']['en']);
        }

        if(request()->hasFile('images')){
            if($category->images && Storage::disk('public')->exists($category->images)){
                Storage::disk('public')->delete($category->images);
            }

            $data['images'] =request()->file('images')
                ->store('categories', 'public');
        }else{
            unset($data['images']);
        }
        $data['status']=$data['status'] ??0;

        return $this->repository->update($id,$data);
    }

    public function deleteCategory(int $id){
        $category=$this->repository->findOrFail($id);

        if($category->images && Storage::disk('public')->exists($category->images)){
            Storage::disk("public")->delete($category->images);
        }

        return $this->repository->delete($id);
    }
    
}