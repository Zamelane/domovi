<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;

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

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function ($unauthorized) {
       $unauthorized->post      ('login',          'loginUser'       );
       $unauthorized->post      ('login.employee', 'loginEmployee'   );
       $unauthorized->prefix('sms')
           ->group(function ($sms) {
              $sms->post        ('send',            'sendSMSByNumber');
           });
       $unauthorized->middleware('auth')->group(function ($authorized) {
           $authorized->get     ('logout',          'logout'         );
           $authorized->post    ('me',              'me'             );
       });
    });
