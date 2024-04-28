<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenYouException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Advertisement\AdvertisementCreateRequest;
use App\Http\Requests\Advertisement\AdvertisementEditRequest;
use App\Http\Resources\Advertisements\AdvertisementResource;
use App\Http\Utils\RulesChecker;
use App\Models\Advertisement;
use App\Models\Photo;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function create(AdvertisementCreateRequest $request) {
        // Проверяем фильтры
        $options = FilterController::getFiltersRules($request->advertisement_type_id);
        RulesChecker::check($options);

        // Создаём объявление
        $advertisement = Advertisement::createByRequest();

        // Сохраняем фотографии из объявления
        Photo::saveFromRequestByAdvertisementId($advertisement->id);

        // Сохраняем значения фильтров
        FilterController::saveOptionsToAd($advertisement->id);

        return response([
            "advertisement_id" => $advertisement->id
        ], 201);
    }

    public function edit(AdvertisementEditRequest $request, int $id)
    {
        $advertisement = Advertisement::find($id);

        if (!$advertisement)
            throw new NotFoundException();

        $user = auth()->user();

        // Если пользователь не относится к работнику и не является автором объявления, то выкидываем в ошибку
        if (array_search($user->role->code, ["admin", "owner"]) === false
            && $user->id != $advertisement->user->id)
            throw new ForbiddenYouException();

        // Если пользователь - менеджер, то ограничиваем его в правах
        if ($user->role->code === "owner")
            if ($advertisement->is_moderated !== null
                || !Advertisement::checkEmployeeRelationsByAdvertisement($user->id, $advertisement->id))
                throw new ForbiddenYouException();

        // Проверяем фильтры. Если переданы, то должны быть включены и все обязательные фильтры
        if (isset($request->options)
            || (isset($request->advertisement_type_id)
                && $request->advertisement_type_id !== $advertisement->advertisement_type->id)) {
            // Получаем обязательные фильтры
            $options = FilterController::getFiltersRules($advertisement->advertisement_type->id);
            // Проверяем наличие обязательных фильтров в запросе
            RulesChecker::check($options);
            // Сохраняем значения фильтров
            FilterController::saveOptionsToAd($advertisement->id);
        }

        // Проверяем картинки. Если переданы, то загружаем
        if (isset($request->photos))
            Photo::saveFromRequestByAdvertisementId($advertisement->id);
        // Если переданы картинки для удаления, то удаляем
        if (isset($request->photosToDelete))
            Photo::deleteNotIn($request["photosToDelete"], $advertisement->id);

        // Обновляем объявление
        $advertisement->update([
            ...request()->all(),
            "user_id" => $advertisement->user_id
        ]);

        return response(null, 202);
    }

    public function show(Request $request, int $id)
    {
        $advertisement = Advertisement::find($id);

        if (!$advertisement)
            throw new NotFoundException("Advertisement");

        if ($advertisement->is_deleted === true
            || $advertisement->is_moderated === false)
            if ($advertisement->user_id != auth()->user()->id)
                throw new ForbiddenYouException();

        return response(AdvertisementResource::make($advertisement), 200);
    }
}
