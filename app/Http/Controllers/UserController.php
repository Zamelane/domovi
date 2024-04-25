<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\ForbiddenYouException;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Возвращает аутентифицированного пользователя.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response(UserResource::make(auth()->user()));
    }

    public function show(int $id)
    {
        $user = User::find($id);

        if (!$user)
            throw new ApiException(401, 'User not found');

        if (auth()->user()->role->code === 'user') {
            if ($user->role->code === 'admin')
                throw new ForbiddenYouException();
        }

        return response(UserResource::make($user));
    }

    public function list() {
        return response([
            'users' => UserResource::collection(User::simplePaginate(15)->all()),
            'allPages' => ceil(User::count() / 15)
        ]);
    }

    public function search(UserRequest $request) {
        $searchParams = request(['first_name', 'last_name', 'patronymic', 'phone']);
        return response(UserResource::collection(User::searchByParams($searchParams)));
    }
}
