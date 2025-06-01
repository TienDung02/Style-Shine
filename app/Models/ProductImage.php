<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image_url',
        'is_primary',
        'product_id',
    ];
    protected $dates = ['deleted_at'];

    public function productImage()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
