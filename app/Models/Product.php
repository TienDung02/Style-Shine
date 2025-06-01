<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;


    protected $fillable = [
        'name',
        'price',
        'quantity',
        'description',
        'category_id',
        'brand_id',
    ];
    protected $dates = ['deleted_at'];

    public function searchableAs(): string
    {
        return 'products';
    }
    public function toSearchableArray(): array
    {
        $array = $this->toArray();
//        dd($this->all());

        return $array;
    }
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
