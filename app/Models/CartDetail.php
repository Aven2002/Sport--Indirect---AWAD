<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    protected $table ='cart_details';

    protected $fillable = [
        'cart_id',
        'product_id',
        'size',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
