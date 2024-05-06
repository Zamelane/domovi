<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenForYouException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Advertisement\AdvertisementCreateRequest;
use App\Http\Requests\Advertisement\AdvertisementEditRequest;
use App\Http\Requests\Advertisement\SearchAdvertisementRequest;
use App\Http\Resources\Advertisements\AdvertisementMinResource;
use App\Http\Resources\Advertisements\AdvertisementResource;
use App\Http\Utils\RulesChecker;
use App\Models\Advertisement;
use App\Models\Filter;
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
        $params = [];
        $advertisement = Advertisement::find($id);

        if (!$advertisement)
            throw new NotFoundException();

        $user = auth()->user();

        // Если пользователь не относится к работнику и не является автором объявления, то выкидываем в ошибку
        if (array_search($user->role->code, ["admin", "owner"]) === false
            && $user->id != $advertisement->user_id)
            throw new ForbiddenForYouException();

        // Если редактирует автор, то отправляем на модерацию
        if ($user->role->code === "owner") {
            $params = [
                "is_moderated" => null,
                "is_active" => false
            ];
        }

        // Если пользователь - менеджер, то ограничиваем его в правах
        if ($user->role->code === "manager")
            if ($advertisement->is_moderated !== null
                || !Advertisement::checkEmployeeRelationsByAdvertisement($user->id, $advertisement->id))
                throw new ForbiddenForYouException();

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
            "user_id" => $advertisement->user_id,
            ...$params
        ]);

        return response(null, 202);
    }

    public function show(Request $request, int $id)
    {
        $advertisement = Advertisement::find($id);

        if (!$advertisement)
            throw new NotFoundException("Advertisement");

        // TODO: сделать проверку, что менеджер обрабатывал сделку и тоже имеет доступ (как и админ)
        if ($advertisement->is_deleted === true
            || $advertisement->is_moderated !== true
            || $advertisement->is_archive === true)
            if ($advertisement->user_id !== (auth()->user()->id ?? null))
                throw new ForbiddenForYouException();

        return response(AdvertisementResource::make($advertisement), 200);
    }

    // TODO: Привести в порядок
    public function search(SearchAdvertisementRequest $request)
    {
        $query = Advertisement::select('advertisements.*');

        if ($request->min_cost)
            $query->where("cost", ">=", $request->min_cost);
        if ($request->max_cost)
            $query->where("cost", "<=", $request->max_cost);
        if ($request->area)
            $query->where("area", ">=", $request->area);

        $query->where([...request(['advertisement_type_id', 'transaction_type'])]);

        if ($request->filters) {
            $id = 0;
            foreach ($request->filters as $filter => $value)
            {
                if ($value != null)
                    $query->join("ad_filter_values as {$id}afv", function ($join) use ($value, $filter, $id) {
                        $join->on("{$id}afv.advertisement_id", "=", "advertisements.id")
                            ->where("{$id}afv.value", "=", $value)
                            ->join("filters as {$id}f", function ($join) use ($filter, $id) {
                                $filterKeys = explode("_", $filter);
                                $filter = $filterKeys[count($filterKeys) - 1];
                                $where = $filterKeys[0];
                                switch ($where) {
                                    case "min": $where = ">="; break;
                                    case "max": $where = "<="; break;
                                    default: $where = "="; break;
                                }
                                $join->on("{$id}f.id", "=", "{$id}afv.filter_id")
                                    ->where("{$id}f.code", $where, $filter);
                            });
                    });
                $id++;
            }
        }
        if ($request->city || $request->street) {
            $query->join("addresses", "advertisements.address_id", "=", "addresses.id")
                ->join("streets", "addresses.street_id", "=", "streets.id")
                ->join("cities", "cities.id", "=", "streets.city_id");
            if ($request->city)
                $query->where("cities.name", $request->city);
            if ($request->street)
                $query->where("streets.name", $request->street);
        }

        return response([
            "advertisements" => AdvertisementMinResource::collection($query->simplePaginate()),
            "allPages" => ceil($query->count() / 15)
        ]);
    }

    public function me()
    {
        $user = auth()->user();
        $query = Advertisement::where('user_id', $user->id);
        return response([
            "advertisements" => AdvertisementMinResource::collection($query->simplePaginate(15)->all()),
            "allPages" => ceil($query->count() / 15)
        ]);
    }
}
