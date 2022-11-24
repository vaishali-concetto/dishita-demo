<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'name',
        'desc',
        'image',
        'price',
        'brand_id'
    ];

    public function brand() {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
