<?php
namespace App\Repositries;

use App\Interfaces\BrandInterFace;
use App\Models\Brand;
use Override;

class  BrandRepositry  implements BrandInterFace{
    public function all(){
        return Brand::latest()->get();
    }

    public function create(array $data){
        return Brand::create($data);
    }

    public function findOrFail(int $id)
    {
        return Brand::findOrFail($id);
    }
    public function find(int $id)
    {
        return Brand::find($id);
    }

    public function update(int $id , array $data){
        $brand=Brand::findOrFail($id);
        return $brand->update($data);
    }


    public function delete($id){
        $brand=Brand::findOrFail($id);
        return $brand->delete();
    }

    public function count(){
        return Brand::count();
    }
    public function getActiveWithProductCount()
{
    return Brand::where('status', 1)
        ->withCount(['products' => fn($q) => $q->where('status', 1)])
        ->orderBy('name->en')
        ->get();
}
}