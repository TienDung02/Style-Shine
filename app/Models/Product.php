<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $fillable = [
        'name_product',
        'price',
        'quantity',
        'description',
        'id_category',
        'image_url',
        'brand',
    ];


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function productImage()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

}
