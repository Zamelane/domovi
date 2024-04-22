<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    use HasFactory;

    // Заполняемые поля
    protected $fillable = [
        'token'
    ];

    /** Связи **/
    // User <-->> Auths
    public function users()
    {
        return $this->hasMany(User::class);
    }
    // Employee <-->> Auths
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
