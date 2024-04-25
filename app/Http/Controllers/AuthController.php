<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\InvalidAuthData;
use App\Http\Requests\Auth\ConfirmLoginUserRequest;
use App\Http\Requests\Auth\LoginEmployeeRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\SignupUserRequest;
use App\Http\Requests\Auth\SMSSendRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\Role;
use App\Models\Sms;
use App\Models\User;
use Request;

class AuthController extends Controller
{
    public function loginUser(LoginUserRequest $request) {
        // Получаем входные данные
        $phone = $request->get('phone');
        $ip = Request::ip();

        // Ищем пользователя по номеру телефона
        $user = User::getByPhone($phone);

        if (!$user)
            throw new InvalidAuthData();

        $sms = Sms::sendSMS($phone, $ip);

        return response([
            $sms
        ]);
    }
    public function confirmLogin(ConfirmLoginUserRequest $request)
    {
        // Получаем токен смс-подтверждения и код для проверки
        $smsToken = $request->get('sms_token');
        $smsCode = $request->get('code');

        $phone = Sms::verify($smsToken, $smsCode);

        $user = User::getByPhone($phone);

        if (!$user) {
            return response()->json(['error' => 'User is not registered'], 401);
        }

        return response([
            'token' => auth()->login($user)
        ]);
    }

    public function loginEmployee(LoginEmployeeRequest $request)
    {
        $credentials = request(['login', 'password']);

        $employee = User::getEmployeeByCredentials($credentials);

        if (!$employee)
            throw new InvalidAuthData();

        return response([
            'token' => auth()->login($employee)
        ]);
    }

    public function signup(SignupUserRequest $request)
    {
        $smsToken = $request->input('sms_token');
        $smsCode = $request->input('code');

        if (!$smsToken || !$smsCode) {
            $sms = Sms::sendSMS($request->get('phone'), Request::ip());
            return response($sms);
        }

        Sms::verify($smsToken, $smsCode);

        $role =  $request->input('role') ?? "user";
        $roleId = Role::firstOrCreate(['code' => $role])->id;

        $user = User::create([
            ...$request->all(),
            'role_id' => $roleId
        ]);

        return response([
            "token" => auth()->login($user)
        ])->setStatusCode(201);
    }

    public function logout(Request $request)
    {
        auth()->invalidate(true);
        return response([
           "success" => true
        ]);
    }
}
