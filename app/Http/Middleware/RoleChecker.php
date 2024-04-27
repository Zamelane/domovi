<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Exceptions\ForbiddenYouException;
use App\Exceptions\YouBannedException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleChecker
{
    private $levels = [
        'guest',
        'user',
        'owner',
        'manager',
        'admin'
    ];

    public function handle(Request $request, Closure $next, $allowedLevel = 'guest'): Response
    {
        $allowedLevels = explode('|', $allowedLevel);
        // Определяем роль пользователя
        $user = auth()->user();
        $userRole = $user->role->code;
        $block = false;

        User::checkAvailable($user);

        if (count($allowedLevels) === 1) {
            $searchUp = $allowedLevel[0];
            $allowedOperations = ["^", "_"];
            if (array_search($searchUp, $allowedOperations) === false) {
                $searchUp = "=";
            }
            $allowedLevel = array_search(str_replace(["^", "_", "="], "", $allowedLevel), $this->levels);
            // Определяем уровень доступа пользователя
            $userAllowedLevel = array_search($userRole, $this->levels);

            // Если у пользователя уровень доступности ниже заданного, то выводим 403 ошибку
            if ($searchUp === "^" && $userAllowedLevel < $allowedLevel
                || $searchUp === "^^" && $userAllowedLevel <= $allowedLevel
                || $searchUp === "_" && $userAllowedLevel > $allowedLevel
                || $searchUp === "=" && $userAllowedLevel != $allowedLevel)
                $block = true;
        }

        if ($block || array_search($userRole, $allowedLevels) === -1)
            throw new ForbiddenYouException();

        return $next($request);
    }
}