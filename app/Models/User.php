<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\ApiException;
use App\Exceptions\YouBannedException;
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
        'password' => 'hashed'
    ];

    public static function getByPhone($phone)
    {
        return User::where('phone', $phone)->first();
    }

    public static function searchByParams($params)
    {
        $wheres = [];
        foreach ($params as $key => $value) {
            $wheres[] = [$key, 'LIKE', "%$value%"];
        }

        return User::where($wheres)->simplePaginate(15);
    }

    public static function checkAvailable(User $user) {
        if ($user->is_banned)
            throw new YouBannedException();
        if ($user->is_passed_moderation == null)
            throw new ApiException(401, 'You process moderated');
        if ($user->is_passed_moderation == false)
            throw new ApiException(401, 'You have not passed moderation');
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
