<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceDetailFactory> */
    use HasFactory;

    protected $fillable = [
        'quality',
        'id_product',
        'id_invoice',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id_invoice');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
