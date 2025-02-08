<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'resellerID',
        'productID',
        'reseller_price',
    ];
}
