<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\FragranceNote;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations,HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'gender',
        'is_featured',
        'is_bestseller',
        'status',
        'images',
        'stock_quantity',
        'low_stock_threshold',
        'is_out_of_stock',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'status' => 'boolean',
        'is_out_of_stock' => 'boolean',
        'price' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public $translatable = [
        'name',
        'description',
        'short_description',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function fragranceNotes()
{
    return $this->belongsToMany(
        FragranceNote::class,
        'product_fragrance_notes'
    )->withPivot('type');
}
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes');
    }

public function stockMovements()
{
    return $this->hasMany(Stock_movement::class);
}
public function reviews(){
    return $this->hasMany(Review::class);
}
}
