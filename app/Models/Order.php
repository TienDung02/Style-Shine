<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $table = 'invoice';
    protected $fillable = [
        'id',
        'delivery_status',
         'payment_method',
         'total_price',
         'username',
    ];
    public function user()
    {
        return $this->belongsTo(Customer::class, 'username', 'username');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

}
