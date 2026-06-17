<?php
namespace App\Servicies;

use App\Interfaces\ProductInterface;
use App\Services\StockService;
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

    public function createProduct(array $data){
        //generate slug
        if(isset($data['name']['en'])){
            $slug=Str::slug($data['name']['en']);
            $original=$slug;
            $count=1;
            while($this->repository->findBySlug($slug)){
                $slug=$original .'-'.$count++;
            }
            $data['slug']=$slug;
        }
        //handle image upload
        if (request()->hasFile('image')) {
            $data['image'] = request()->file('image')->store('products', 'public');
        }
        //Image update
        if (request()->hasFile('image')) {
            $data['image'] = request()->file('image')->store('products', 'public');
        }
        //create product
        $product=$this->repository->create($data);
        //handel stock
        if(isset($data['stock_quantity']) && $data['stock_quantity']>0){
            $this->stockService->increase($product,$data['stock_quantity'],'opening stock');
        }
        return $product;
    }
    
    public function updateProduct(int $id,array $data){
        //generate slug if name changed
        if(isset($data['name']['en'])){
            $slug=Str::slug($data['name']['en']);
            $original=$slug;
            $count=1;
            while($this->repository->findBySlugExceptId($slug,$id)){
                $slug=$original .'-'.$count++;
            }
            $data['slug']=$slug;
        }
        //update product
        $product=$this->repository->update($id,$data);
        //return updated product
        return $this->repository->findOrFail($id);
    }
    
    public function deleteProduct(int $id): bool
    {
        return $this->repository->delete($id);
    }
    

}