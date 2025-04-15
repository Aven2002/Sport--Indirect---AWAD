<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'productDetails';
    protected $primaryKey = 'product_id'; 
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'description',
        'stock',
        'imgPath',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
