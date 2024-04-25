<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
       $unauthorized->middleware('auth')->group(function ($authorized) {
           $authorized->get     ('logout',             'logout'          );
           $authorized->post    ('me',                 'me'              );
       });
    });

Route::group([
    "controller" => UserController::class,
    "middleware" => "auth",
    "prefix" => "users"
], function ($auth) {
    $auth->get('',       'list'  );
    $auth->get('me',     'me'    );
    $auth->get('search', 'search');
    $auth->prefix('{id}')->group(function ($auth) {
        $auth->get('', 'show')->where('id', '[0-9]+');
    });
});
