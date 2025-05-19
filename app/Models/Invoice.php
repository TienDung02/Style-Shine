<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;


    protected $fillable = [
        'total_price',
         'payment_method',
         'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'id_invoice', 'id_invoice');
    }


}
