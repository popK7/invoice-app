<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'brand_id',
        'product_name',
        'category_id',
        'price',
        'color_id',
        'description',
        'product_image',
        'created_by',
        'is_deleted',
    ];

    // protected $casts = ['product_image' => 'array'];

    function brand() {
        return $this->hasOne(Brands::class,'id','brand_id');
    }

    function category() {
        return $this->hasOne(Categories::class,'id','category_id');
    }

    function color() {
        return $this->hasOne(Colors::class,'id','color_id');
    }

    function user() {
        return $this->hasOne(User::class,'id','created_by');
    }

    function product_images() {
        return $this->hasMany(ProductImages::class,'product_id','id');
    }
}
