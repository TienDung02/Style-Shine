<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'name_product',
        'price',
        'quality',
        'description',
        'image_url',
        'id_category',
        'brand',
        'id_review',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_product', 'id_product');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'id_product', 'id_product');
    }
}
