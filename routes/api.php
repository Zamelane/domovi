<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\DocumentController;

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

Route::group([
    "controller" => AdvertisementController::class,
    "prefix" => "advertisement"
], function ($ads) {
    $ads->middleware('check.role:^guest')->group(function ($ad) {
        $ad->get('search','search' );
        $ad->get('{id}',  'show'   )->where('id', '[0-9]+');
    });
    $ads->middleware('auth')
        ->middleware('check.role:^owner')
        ->group(function ($ad) {
            $ad->middleware('check.role:=owner')->post('create', 'create');
            $ad->prefix('{id}')
                ->group(function ($privilegedAd) {
                    $privilegedAd->delete('', 'delete');
                    $privilegedAd->post('', 'edit');
                })
                ->where('id', '[0-9]+');
    });
});

Route::group([
    "controller" => FavouriteController::class,
    "prefix" => "favourites",
    "middleware" => "auth"
], function ($favourites) {
    $favourites->middleware('check.role:user|owner')
        ->prefix('{id}')
        ->group(function ($privilegedFavourite) {
            $privilegedFavourite->delete('', 'delete');
            $privilegedFavourite->put   ('', 'add'   );
        })
        ->where('id', '[0-9]+');
});

Route::group([
    "controller" => DealController::class,
    "prefix" => "deals",
    "middleware" => "auth"
], function ($deals) {
    $deals->get('statuses', 'statuses');
    $deals->middleware('check.role:user|owner')
        ->post('create', 'create');
    $deals->prefix('{dealId}')
        ->group(function ($deal) {
            $deal->get  ('',      'show' );
            $deal->get  ('close', 'close');
            $deal->patch('',      'edit' );
            $deal->controller(DocumentController::class)
                ->group(function ($document) {
                    $document->post('documents', 'upload');
                    $document->get ('documents', 'all'   );
                });
        })
        ->where('dealId', '[0-9]+');
});

Route::group([
    "controller" => AddressController::class,
    "prefix" => "address"
], function ($address) {
    $address->post('get',      'get'      );
    $address->get ('cities',   'getCity'  );
    $address->get ('streets',  'getStreet');
});

Route::group([
    "controller" => OfficeController::class,
    "prefix" => "offices"
], function ($address) {
    $address->get ('',         'get'   );
    $address->middleware('check.role:admin')
        ->group(function ($privilegedAddress) {
            $privilegedAddress->post('create',        'create');
            $privilegedAddress->post('{id}/edit',     'edit'  );
        });
});

Route::group([
    "controller" => DocumentController::class,
    "prefix" => "documents",
    "middleware" => "auth"
], function ($documents) {
    $documents->prefix('{id}')
        ->group(function ($document) {
            $document->get  ('',      'download' );
        })
        ->where('id', '[0-9]+');
});
