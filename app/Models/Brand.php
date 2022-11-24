<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "brands";

    protected $fillable = [
        'name',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'brand_id', 'id');
    }
}
