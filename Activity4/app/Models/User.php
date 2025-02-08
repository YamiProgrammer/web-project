<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tblregistration'; // specify the custom table name

    protected $fillable = [
        'student_id',
        'firstname',
        'lastname',
        'email',
        'mobile_number',
        'username',
        'password',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'retailer_id'); // Assuming 'retailer_id' is the foreign key in the orders table
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
