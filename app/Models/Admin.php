<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
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
}
