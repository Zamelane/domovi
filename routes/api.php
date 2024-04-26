<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// TODO: Выводить красивые ошибки для неопознанных роутов

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function ($unauthorized) {
       $unauthorized->post      ('login.user',         'loginUser'       );
       $unauthorized->post      ('confirm.login',      'confirmLogin'    );
       $unauthorized->post      ('login.employee',     'loginEmployee'   );
       $unauthorized->post      ('signup',             'signup'          );
       $unauthorized->middleware('auth')->get('logout','logout'          );
    });

Route::group([
    "controller" => UserController::class,
    "middleware" => "auth",
    "prefix" => "users"
], function ($users) {
    $users->middleware('check.role:^^guest')->group(function ($me) {
        $me->get('me',       'me'  );
        $me->patch('me',     'edit');
        $me->patch('{id}',   'edit'    )->where('id', '[0-9]+');
    });
    $users->middleware('check.role:^manager')->group(function ($usersAll) {
        $usersAll->get('',       'showAll');
        $usersAll->get('search', 'search' );
        $usersAll->prefix('{id}')->group(function ($user) {
            $user->get('', 'show')->where('id', '[0-9]+');
        });
    });
    $users->middleware('check.role:^admin')->post('create', 'create');
});
