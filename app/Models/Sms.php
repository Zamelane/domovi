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

    // Заполняемые поля
    protected $fillable = [
        'token',
        'phone_id',
        'code',
        'ip',
        'attempts',
        'datetime_sending'
    ];

    // Скрытые поля
    protected $hidden = [
        'code',
        'phone_id',
        'datetime_sending',
        'ip'
    ];

    public static function getSMSByToken($token) {
        $cacheKey = "sms:token=$token";
        return Cache::remember($cacheKey, 360, function () use ($token) {
           $sms = Sms::where('token', $token)->first();
           if (!$sms)
               throw new ApiException(401, 'Invalid sms token');
           return $sms;
        });
    }

    public function reduceAttempts() {
        $cacheKey = "sms:token=$this->token";

        if ($this->attempts > 0) {
            $this->attempts--;
            $this->save();
        }

        Cache::put($cacheKey, 360);
    }

    public static function countMessagesSent($phone, $ip = null)
    {
        return Sms::leftJoin('phones', 'sms.phone_id', '=', 'phones.id')
            ->orWhere([
                ['phones.phone', '=', $phone],
                ['ip', '=', $ip]
            ])
            ->where(
                'sms.datetime_sending', '>=', (new \DateTime('-1 day'))->format('Y-m-d H:i:s')
            )->count();
    }

    // TODO: Додулать тут и в AuthController
    public static function sendSMS($phone, $ip = null) {
        $token = Str::random(25);
        $sms = Sms::create([
            'token' => $token,
            'phone_id' => $phone,
            'ip' => $ip,
            'attempts' => 3,
            'datetime_sending' => date('Y-m-d H:i:s')
        ]);
    }

    /** Связи **/
    // SMS <--> Phone
    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }
}
