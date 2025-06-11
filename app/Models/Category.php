<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;



    public $timestamps = false;
    protected $table = 'category';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'name',
    ];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'ID_CATEGORY', 'ID');
    }
}
