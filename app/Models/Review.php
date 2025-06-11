<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $table = 'review';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'rating',
        'comment',
        'username',
        'id_product',
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'username', 'username');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
