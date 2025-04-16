<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;  // Use the Authenticatable class
use Illuminate\Notifications\Notifiable; // Use the Notifiable trait

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'username',
        'password',
        'dob',
        'profileImg',
        'security_answers',
    ];

    protected $hidden = [
        'password',  // Hide the password attribute
        'remember_token',  // Hide the remember token
    ];

}
