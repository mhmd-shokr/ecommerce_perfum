<?php
namespace App\Interfaces;

Interface BrandInterFace{
    public function all();
    public function create(array $data);
    public function update(int $id,array $data);
    public function delete(int $id);

    public function find(int $id);
    public function findOrFail(int $id);
    public function count();
    

}