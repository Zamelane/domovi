<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\SMSSendRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\Sms;
use App\Models\User;
use Request;

class AuthController extends Controller
{
    public function loginUser(LoginUserRequest $request)
    {
        /*$credentials = request(['login', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);*/

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

        $user = User::getByPhone($sms->phone);

        if (!$user) {
            return response()->json(['error' => 'User is not registered'], 401);
        }

        return response([
            'token' => auth()->login($user),
            'userdata' => UserResource::make($user)
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

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
