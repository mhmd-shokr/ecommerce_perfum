<?php
namespace App\Interfaces;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CategoryInterface{
    public function all();
    public function create(array $data);
    public function update(int $id,array $data);
    public function delete(int $id);
    public function find(int $id);
    public function findOrFail(int $id);

    public function count();
    public function getRoots():collection;
    public function getAllWithChildren():collection;
    public function getCategoryDistribution():collection;
    public function getPaginateCategories(int $perPage=10);





    
}