<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'productName',
        'sportCategory',
        'productCategory',
        'productBrand',
        'has_sizes'
    ];

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }
}
