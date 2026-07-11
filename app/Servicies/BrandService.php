<?php
namespace App\Servicies;

use App\Interfaces\BrandInterFace;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandService{
    protected $brandRepository;
    public function __construct(BrandInterFace $brandRepository)
    {
        $this->brandRepository=$brandRepository;
    }

    public function getBrands(){
        return Cache::remember('home.brands',now()->addHours(1)
        ,fn()=>$this->brandRepository->all()) ;
    }

    public function getBrandById(int $id){
        return $this->brandRepository->findOrFail($id);
    }

    public function createBrand(array $data){
        if(isset($data['name']['en'])){
            $data['slug']=Str::slug($data['name']['en']);
        }
        if(isset($data['logo'])){
            $data['logo']=$data['logo']->store('brands','public');
        }
        return $this->brandRepository->create($data);    
    }

    public function updateBrand(int $id,array $data){
        $brand=$this->getBrandById($id);

        if(isset($data['name']['en'])){
            $data['slug']=Str::slug($data['name']['en']);
        }

        if(request()->hasFile('logo')){
            if($brand->logo && Storage::disk('public')->exists($brand->logo)){
                    Storage::disk('public')->delete($brand->logo);
            } 
            $data['logo']=request()->file('logo')->store('brands','public');
        }else{
            unset($data['logo']);
        }
        return $this->brandRepository->update($id,$data);
    }

    public function deleteBrand($id){
        $brand=$this->getBrandById($id);
        if($brand->logo && Storage::disk('public')->exists($brand->logo)){
            Storage::disk('public')->delete($brand->logo);
        }   
        return $this->brandRepository->delete($id); 
    }
}