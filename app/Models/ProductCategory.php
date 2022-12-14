<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "product_categories";

    protected $fillable = [
        'product_id',
        'category_id',
        'is_sub',
    ];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
