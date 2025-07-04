<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'name',
        'phoneNo',
        'addressLine',
        'city',
        'state',
        'postcode',
        'isDefault'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
