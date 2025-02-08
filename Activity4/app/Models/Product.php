<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'productID';

    protected $fillable = [
        'productName',
        'productDescription',
        'productPrice',
        'productImage',
        'AvailableStocks',
        'categoryID'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID', 'categoryID');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'productID', 'productID');
    }

    public function retailerProduct()
    {
        return $this->hasOne(RetailerProduct::class, 'productID', 'productID');
    }

    public function resellerProduct()
    {
        return $this->hasOne(ResellerProduct::class, 'productID', 'productID');
    }
    
}
