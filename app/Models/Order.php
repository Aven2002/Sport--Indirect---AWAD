<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'address_id',
        'totalPrice',
        'status',
        'paymentMethod'
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
