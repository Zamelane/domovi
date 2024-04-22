<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use \App\Models\User;
use Illuminate\Http\Request;

class AuthByToken
{
    private static $levels = [
        'guest',
        'user',
        'owner',
        'manager',
        'admin'
    ];
    public function handle(Request $request, Closure $next, $allowedLevel = 'guest')
    {
        // Bearer токен из запроса
        $tokenValue = $request->bearerToken();

        // Если токен не передан и доступ для гостей запрещён, то выводим ошибку 401
        if (!$tokenValue) {
            if ($allowedLevel !== 'guest')
                throw new ApiException(401, 'Token not provided');
        } else {
            // Ищем пользователя
            $user = User::getByToken($tokenValue);

            // Определяем уровень доступа пользователя
            $userRole = $user->role->code;
            $userAllowedLevel = array_search($userRole, $this->levels);

            // Определяем минимальный уровень доступа
            $allowedLevel = array_search($allowedLevel, $this->levels);

            // Если у пользователя уровень доступности ниже заданного, то выводим 403 ошибку
            if ($userAllowedLevel < $allowedLevel)
                throw new ApiException(403, 'Forbidden for you');

            // Записываем пользователя в запрос для последующих обработок в контроллерах
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        }

        return $next($request);
    }
}
