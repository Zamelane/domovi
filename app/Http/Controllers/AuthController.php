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
use Illuminate\Support\Facades\Auth;
use Request;

class AuthController extends Controller
{
    public function loginUser(LoginUserRequest $request) {
        // Получаем входные данные
        $phone = $request->get('phone');
        $ip = Request::ip();

        // Ищем пользователя по номеру телефона
        $user = User::getByPhone($phone);
        User::checkAvailable($user);

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
        User::checkAvailable($user);

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
        if (!Auth::attempt($credentials))
            throw new InvalidAuthData();

        $user = Auth::user();
        User::checkAvailable($user);
        $role = $user->role->code;

        if ($role === "user" || $role === "owner")
            throw new InvalidAuthData();

        return response([
            'token' => auth()->login($user)
        ]);
    }

    public function signup(SignupUserRequest $request)
    {
        $smsToken = $request->input('sms_token');
        $smsCode = $request->input('code');

        // Если нет данных для подтверждения номера, то просим его пройти
        if (!$smsToken || !$smsCode) {
            $sms = Sms::sendSMS($request->get('phone'), Request::ip());
            return response($sms);
        }

        // Если идёт регистрация с подтверждением номера, то првоеряем код от смс
        Sms::verify($smsToken, $smsCode);

        // Если код проверен, то подготавливаем роль пользователя
        $role =  $request->input('role') ?? "user";
        $roleId = Role::firstOrCreate(['code' => $role])->id;

        // Регистрируем пользователя в системе
        $user = User::create([
            ...$request->all(),
            'role_id' => $roleId
        ]);

        // Отдаём данные для авторизации
        return response([
            "token" => auth()->login($user)
        ])->setStatusCode(201);
    }

    /**
     * Завершение сеанса пользователя
     */
    public function logout(Request $request)
    {
        auth()->invalidate(true);
        return response([
           "success" => true
        ]);
    }
}
