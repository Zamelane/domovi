<?php

namespace App\Models;

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    static public function getByToken($token)
    {
        $cacheKey = "key:token=$token";
        $user = Cache::remember($cacheKey, 1800, function () use ($token) {
            $authByToken = Auth::where('token', $token)->first();
            if (!$authByToken || $authByToken->employee_id === null)
                throw new ApiException(401, 'Invalid token');
            return $authByToken->user;
        });
        return $user;
    }

    /** Связи **/
    // User <-->> Auth
    public function auths()
    {
        return $this->hasMany(Auth::class);
    }
    // User <--> Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
