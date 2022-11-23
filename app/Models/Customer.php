<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

//    protected $guard = "customer";
    protected $table = "customers";

    protected $fillable = [
        'gender',
        'phone',
        'user_id',
    ];

}
