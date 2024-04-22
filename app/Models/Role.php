<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Заполняемые поля
    protected $fillable = [
        'code'
    ];

    /** Связи **/
    // Role <-->>Users
    public function users()
    {
        return $this->hasMany(User::class);
    }
    // Role <-->> Employee
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
