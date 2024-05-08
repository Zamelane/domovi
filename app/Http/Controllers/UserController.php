<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\ForbiddenForYouException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserEditRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Возвращает аутентифицированного пользователя.
     */
    public function me()
    {
        return response(UserResource::make(auth()->user()));
    }

    public function show(int $id)
    {
        $user = User::find($id);

        if (!$user)
            throw new NotFoundException("User");

        if (auth()->user()->role->code === 'user') {
            if ($user->role->code === 'admin')
                throw new ForbiddenForYouException();
        }

        return response(UserResource::make($user));
    }

    public function showAll() {
        return response([
            'users' => UserResource::collection(User::simplePaginate(15)->all()),
            'allPages' => ceil(User::count() / 15)
        ]);
    }

    public function search(UserRequest $request) {
        $searchParams = request(['first_name', 'last_name', 'patronymic', 'phone', 'is_passed_moderation', 'is_banned']);

        $query = User::searchByParams($searchParams);

        if ($request->role)
            $query->where('role_id', Role::searchByCode($request->role)->id);

        if ($request->is_employee !== null)
        {
            $rolesIds = [Role::searchByCode('admin')->id, Role::searchByCode('manager')->id];
            if ($request->is_employee == true)
                $query->whereIn('role_id', $rolesIds);
            else
                $query->whereNotIn('role_id', $rolesIds);
        }
        return response(UserResource::collection($query->simplePaginate()));
    }

    public function edit(UserEditRequest $request, int $id = null)
    {
        if ($id) {
            $editUser = User::find($id);
            if (!$editUser)
                throw new NotFoundException("User");
        } else {
            $editUser = auth()->user();
        }

        $editCredentials = $request->all();
        $currUser = auth()->user();
        if (array_search($currUser->role->code, ["user", "owner"]) > -1) {
            if ($currUser->id !== $id)
                throw new ForbiddenForYouException();
            $editCredentials = request(["first_name", "last_name", "middle_name"]);
        } else {
            if ($currUser->role->code !== "admin")
                if ($editUser->role->code === "admin")
                    throw new ForbiddenForYouException();
            if ($request->role) {
                if ($request->role === "admin" && $currUser->role->code !== "admin")
                    $request->role = "manager";
                $role = Role::where('code', $request->role)->first();
                $editUser->role_id = $role->id;
            }
        }

        $editUser->update($editCredentials);
        return response(null, 202);
    }

    public function create(UserCreateRequest $request)
    {
        // Если пытаемся создать работника, то валидируем заполнение ВСЕХ ПОЛЕЙ
        $role = $request->role ?? "user";

        if (array_search($role, ['owner', 'user']) === false) {
            $validator =  Validator::make($request->all(),[
                'login' => 'required|string|unique:users',
                'password' => 'required|string|min:6|max:50',
                'is_banned' => 'boolean',
                'is_passed_moderation' => 'required|boolean'
            ]);
            if ($validator->fails())
                throw new ApiException(422, 'Request validation error', $validator->errors());
        }


        return User::create([
            ...$request->all(),
            'role_id' => Role::firstOrCreate(['code' => $role])->id
        ]);
    }
}
