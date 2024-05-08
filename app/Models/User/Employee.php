<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Заполняемые поля
    protected $fillable = [
        'login',
        'role_id',
        'password',
        'last_name',
        'first_name',
        'patronymic',
        'phone',
        'is_banned'
    ];

    // Скрытые поля
    protected $hidden = [
        'password'
    ];

    // Хеширование пароля
    protected $casts = [
        'password' => 'hashed'
    ];

    /** Связи **/
    // User <--> Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
