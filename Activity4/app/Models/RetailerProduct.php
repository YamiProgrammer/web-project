<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailerProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'retailerID',
        'productID',
        'retailer_price',
    ];
}
