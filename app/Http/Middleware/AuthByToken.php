<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use \App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;

class AuthByToken
{
    public function handle(Request $request, Closure $next)
    {
        // Bearer токен из запроса
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
                throw new ApiException(401, 'Token is Expired');
            else
                throw new ApiException(401, 'Token is Invalid');
        }

        // Записываем пользователя в запрос для последующих обработок в контроллерах
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
