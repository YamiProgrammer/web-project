<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerOrder extends Model
{
    use HasFactory;

    protected $fillable =[
        'reseller_id',
        'productID',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }
}
