<?php

use Illuminate\Support\Facades\Route;
use App\Exceptions\ApiException;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\StatisticsController;

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

// Управление авторизацией
Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function ($unauthorized) {
       $unauthorized->post      ('login.user',         'loginUser'       );
       $unauthorized->post      ('confirm.login',      'confirmLogin'    );
       $unauthorized->post      ('login.employee',     'loginEmployee'   );
       $unauthorized->post      ('signup',             'signup'          );
       $unauthorized->middleware('auth')->get('logout','logout'          );
    });

// Управление пользователями
Route::group([
    "controller" => UserController::class,
    "middleware" => "auth",
    "prefix" => "users"
], function ($users) {
    $users->middleware('check.role:^^guest')->group(function ($me) {
        $me->get  ('me',       'me'    );
        $me->patch('me',     'edit'    );
        $me->patch('{id}',   'edit'    )->where('id', '[0-9]+');
    });
    $users->middleware('check.role:^manager')->group(function ($usersAll) {
        $usersAll->get('',       'showAll');
        $usersAll->get('search', 'search' );
    });

    $users->middleware('check.role:^admin')->post('create', 'create');
});

// Публичные роуты пользователей
Route::group([
    "controller" => UserController::class,
    "prefix" => "users"
], function ($users) {
    $users->prefix('{id}')->group(function ($user) {
        $user->get('', 'show')->where('id', '[0-9]+');
    });
});

// Управление объявлениями
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
            $ad->get('me', 'me');
            $ad->prefix('{id}')
                ->group(function ($privilegedAd) {
                    $privilegedAd->delete('', 'delete');
                    $privilegedAd->post('', 'edit');
                })
                ->where('id', '[0-9]+');
    });
});

// Управление избранным
Route::group([
    "controller" => FavouriteController::class,
    "prefix" => "favourites",
    "middleware" => "auth"
], function ($favourites) {
    $favourites->middleware('check.role:user|owner')
        ->group(function ($privilegedFavourite) {
            $privilegedFavourite->delete('{id}', 'delete');
            $privilegedFavourite->put   ('{id}', 'add'   );
            $privilegedFavourite->get   (''    , 'list'  );
        })
        ->where('id', '[0-9]+');
});

// Управление сделками
Route::group([
    "controller" => DealController::class,
    "prefix" => "deals",
    "middleware" => "auth"
], function ($deals) {
    $deals->get('statuses', 'statuses');
    $deals->middleware('check.role:user|owner')
        ->group(function ($deal) {
            $deal->post('create', 'create');
            $deal->get('me', 'me');
        });
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

// Управление адресами
Route::group([
    "controller" => AddressController::class,
    "prefix" => "address"
], function ($address) {
    $address->post('get',      'get'      );
    $address->get ('cities',   'getCity'  );
    $address->get ('streets',  'getStreet');
});

// Управление офисами
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

// Управление документами
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

// Управление отзывами
Route::group([
    "controller" => ReviewController::class,
    "prefix" => "reviews"
], function ($reviews) {
    $reviews->middleware('check.role:user|owner')->group(function ($review) {
        $review->post  ('create'     , 'create');
        $review->get   ('me'         , 'listMe');
        $review->delete('{id}'       , 'delete');
        $review->post  ('{id}'       , 'edit'  );
    });
    $reviews->middleware('check.role:^manager')->group(function ($review) {
       $review->get  ('moderated.list', 'awaitModeratedList');
       $review->patch('{id}'          , 'setModeratedStatus');
       $review->middleware('check.role:=admin')->get('search', 'search');
    });
    $reviews->get('advertisement/{advId}',  'list')->where('id', '[0-9]+');
    $reviews->get('{id}'                 ,  'show');
});

// Упарвление жалобами
Route::group([
    "controller" => ComplaintController::class,
    "prefix" => "complaints",
    "middleware" => "auth"
], function ($complaints) {
    $complaints->middleware('check.role:user|owner')->post('create', 'create');
    $complaints->middleware('check.role:^manager')->group(function ($complaint) {
        $complaint->get('moderated.list', 'awaitModeratedList');
        $complaint->post('{id}/review',   'review');
    });
});

// Просмотр фильтров
Route::group([
    "controller" => FilterController::class,
    "prefix" => "filters",
], function ($filters) {
    $filters->get(''     , 'get'  );
    $filters->get('types', 'types');
});

Route::group([
    "controller" => StatisticsController::class,
    "prefix" => "statistics"
], function ($statistics) {
    $statistics->get('all.completed.deals', 'allCompletedDeals');
    $statistics->middleware('check.role:admin|manager')->group(function ($statistic) {
        $statistic->get('income.for.period', 'incomeForPeriod');
    });
});

// Если подходящего роутера не нашлось
Route::get('/{any}', function () {
    throw new ApiException(404, 'Not found');
});
