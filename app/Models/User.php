<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;

    // Заполняемые поля
    protected $fillable = [
        'role_id',
        'phone',
        'first_name',
        'last_name',
        'patronymic',
        'is_passed_moderation',
        'is_banned'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password'
    ];

    public static function getByPhone($phone)
    {
        return User::where('phone', $phone)->first();
    }

    public static function getEmployeeByCredentials($credentials)
    {
        return User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where($credentials)
            ->where(function ($q) {
                $q->where('roles.code', 'admin')
                    ->orWhere('roles.code', 'manager');
            })
            ->first();
    }

    public static function searchByParams($params)
    {
        $wheres = [];
        foreach ($params as $key => $value) {
            $wheres[] = [$key, 'LIKE', "%$value%"];
        }

        return User::where($wheres)->simplePaginate(15);
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

    // JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
