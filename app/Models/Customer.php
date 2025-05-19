<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
    protected $fillable = [
        'username',
        'password',
        'cus_name',
        'email',
        'phone_number',
        'address',
        'sex',
        'opt',
        'avatar_url',
        'dob',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'username', 'username');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'username', 'username');
    }
}
