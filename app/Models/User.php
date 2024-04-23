<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    static public function getByToken($token)
    {
        $authByToken = Auth::where('token', $token)->first();
        if (!$authByToken || $authByToken->user_id === null)
            throw new ApiException(401, 'Invalid token');
        return $authByToken->user;
    }

    public static function getByPhone($phone)
    {
        return User::where('phone', $phone)->first();
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
