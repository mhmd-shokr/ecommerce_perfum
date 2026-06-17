<?php
namespace App\Interfaces;

Interface ProductInterface{
    public function all();
    public function find(int $id);
    public function findOrFail(int $id);

    public function create(array $data);
    public function update(int $id,array $data);

    public function delete(int $id);

    public function count ();
    
    public function getByCategory(int $categoryId);

    public function getActiveWithRelations();
    public function getPaginatedActiveWithRelations(int $perPage=10);

    public function findWithRelations(int $id);
    // public function getTopSelling(int $count=5);

    public function countActive();

    public function findBySlug(string $slug);

    public function findBySlugExceptId(string $slug,int $id);

}