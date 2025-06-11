<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    /** @use HasFactory<\Database\Factories\OrderDetailFactory> */
    use HasFactory;
    protected $table = 'invoice_detail';
    protected $fillable = [
        'quantity',
        'invoice_id',
        'product_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'invoice_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'ID_PRODUCT');
    }
}
