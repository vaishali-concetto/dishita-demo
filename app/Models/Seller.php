<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Model
{
    use HasFactory;
    use SoftDeletes;

//    protected $guard = "seller";
    protected $table = "sellers";

    protected $fillable = [
        'company_name',
        'duns',
        'ein',
        'web_url',
        'phone',
        'address',
        'state',
        'city',
        'zipcode',
        'user_id',
    ];
}
