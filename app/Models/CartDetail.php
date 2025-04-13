<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    protected $table ='cart_details';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    //To automatically retrieve product details when fetching cart items
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
