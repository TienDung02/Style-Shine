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
    public $timestamps = false;
    protected $table = 'product';
    protected $primaryKey = 'ID_PRODUCT';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'name_product',
        'price',
        'quality',
        'description',
        'id_category',
        'image_url',
        'brand',
    ];


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id_product');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ID', 'id_category');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function productImage()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id_category');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_product', 'id_product');
    }

}
