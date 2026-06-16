<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'images',
        'status'
    ];

    public $translatable = ['name'];
    public function parent(){
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class,'parent_id');
    }

    public function products(){
        return  $this->hasMany(Product::class);
    }
}

