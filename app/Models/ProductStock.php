<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'product_stock';
    
    protected $fillable = [
        'product_id',
        'size',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
