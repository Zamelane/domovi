<?php

namespace App\Models;

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Sms extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Заполняемые поля
    protected $fillable = [
        'token',
        'phone',
        'code',
        'ip',
        'attempts',
        'datetime_sending'
    ];

    // Скрытые поля
    protected $hidden = [
        'code',
        'id'
    ];

    public static function getSMSByToken($token) {
        $cacheKey = "sms:token=$token";
        $sms = Cache::get($cacheKey);

        if (!$sms)
            $sms = Sms::where('token', $token)->first();

        if (!$sms)
            throw new ApiException(401, 'Invalid sms token');

        Cache::put($cacheKey, $sms, 360);

        return $sms;
    }

    public function reduceAttempts() {
        $cacheKey = "sms:token=$this->token";

        if ($this->attempts > 0) {
            $this->attempts--;
            Sms::where('token', $this->token)->update(['attempts' => $this->attempts]);
        }

        Cache::put($cacheKey, $this);
    }

    public function setAsSuccessful() {
        $cacheKey = "sms:token=$this->token";

        if ($this->code != null) {
            $this->code = null;
            Sms::where('token', $this->token)->update(['code' => $this->null]);
        }

        Cache::put($cacheKey, $this);
    }

    public static function countMessagesSent($phone, $ip = null)
    {
        return Sms::where('datetime_sending', '>=', (new \DateTime('-1 day'))->format('Y-m-d H:i:s'))
            ->where(function ($q) use ($ip, $phone) {
                $q->where('phone', '=', $phone)
                    ->orWhere('ip', '=', $ip);
            })->count();
    }

    public static function sendSMS($phone, $ip = null) {
        // Подсчитываем отправленные смс
        $countMessagesSent = Sms::countMessagesSent($phone, $ip);

        // Если отправлено больше 5 сообщений за день, то выбрасываем ошибку 429
        if ($countMessagesSent > 5)
            throw new ApiException(429, 'Limitation of sending sms');

        $token = Str::random(25);
        $code = strtoupper(Str::random(6));
        return Sms::create([
            'token' => $token,
            'phone' => $phone,
            'code' => $code,
            'ip' => $ip,
            'attempts' => 3,
            'datetime_sending' => date('Y-m-d H:i:s')
        ]);
    }

    public static function verify($smsToken, $smsCode) {
        $sms = Sms::getSMSByToken($smsToken);

        if ($sms->code === null)
            throw new ApiException(401, 'The session has already been completed');

        if ($sms->attempts <= 0)
            throw new ApiException(401, 'The attempts are over');

        if ($sms->code != $smsCode) {
            $sms->reduceAttempts();
            throw new ApiException(401, 'Invalid sms code');
        }

        $sms->setAsSuccessful();

        return $sms->phone;
    }

    // Связанный с смс пользователь
    public function user()
    {
        $phoneNumber = $this->phone;
        $cacheKey = "user:phone=$phoneNumber";

        $user = Cache::get($cacheKey);

        if ($user)
            return $user;

        $user = User::where('phone', $phoneNumber);

        if($user)
            Cache::put($cacheKey, $user, 360);
        return $user;
    }
}
