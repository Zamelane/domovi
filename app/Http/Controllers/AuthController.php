<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\SMSSendRequest;
use App\Models\Sms;
use Request;

class AuthController extends Controller
{
    public function loginUser(LoginUserRequest $request)
    {
        // Получаем токен смс-подтверждения и код для проверки
        $smsToken = $request->get('sms_token');
        $smsCode = $request->get('code');

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

        return response([
            $sms->code
        ]);
    }

    public function sendSMSByNumber(SMSSendRequest $request) {
        // Получаем данные о клиенте
        $phone = $request->get('phone');
        $ip = Request::ip();

        // Подсчитываем отправленные смс
        $countMessagesSent = Sms::countMessagesSent($phone, $ip);

        // Если отправлено больше 5 сообщений за день, то выбрасываем ошибку 429
        if ($countMessagesSent > 5) {
            throw new ApiException(429, 'Limitation of sending sms');
        }

        $sms = Sms::sendSMS($phone, $ip);

        return response([
            $sms
        ]);
    }
}
