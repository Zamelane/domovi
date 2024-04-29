<?php

namespace App\Http\Controllers;

use App\Models\AdFilterValue;
use App\Models\AdvertisementTypeFilter;
use App\Models\Filter;

class FilterController extends Controller
{
    /**
     * Генерирует правила для проверки наличия фильтров в запросе.
     * @param $advertisement_type_id
     * @return array|null
     */
    public static function getFiltersRules($advertisement_type_id, $filterPrefix = "options")
    {
        // Получаем все связи фильтраи и типа объявления
        $relationsFilters = AdvertisementTypeFilter::where("advertisement_type_id", $advertisement_type_id)->get();
        // Для каждой связи извлекаем фильтр и генерируем под него правило валидации
        foreach ($relationsFilters as $relation) {
            $filter = $relation->filter;
            switch ($filter->type) {
                case "write_number":
                    $filtersRules["$filterPrefix.{$filter->code}"] = "required|decimal:0,2|min:0|max:3000.00";
                    break;
                case "summer_number":
                    $filtersRules["$filterPrefix.{$filter->code}"] = "required|integer|min:0|max:10";
                    break;
                case "write_text":
                    $filtersRules["$filterPrefix.{$filter->code}"] = "required|string|min:2|max:32";
                    break;
                case "select":
                    $in = "";
                    foreach ($filter->filter_values as $v)
                        $in .= ($in != "" ? "," : "") . $v->value;
                    if ($in != "")
                        $filtersRules["$filterPrefix.{$filter->code}"] = "required|in:$in";
                    break;
            }
        }
        return $filtersRules ?? null;
    }

    /**
     * Сохраняет фильтры для объявления.
     * Все непереданные значения фильтров автоматически удаляются из БД.
     * @param int $advertisement_id
     * @return void
     */
    public static function saveOptionsToAd(int $advertisement_id)
    {
        $filters = request()->options;
        $idsToSave = [];
        foreach ($filters as $key => $value) {
            // Убираем из ключа вложенность массивов (например: "filters.field" должно стать "field")
            $keys = explode(".", $key);
            $keyFormate = $keys[count($keys) - 1];
            // Получаем фильтр по ключу
            $filter = Filter::where("code", $keyFormate)->first();
            // Если полученного фильтра нет в БД, то не обрабатываем его
            if (!$filter)
                continue;
            // А если фильтр в БД есть, то сохраняем в список не удаляемых
            $idsToSave[] = $filter->id;
            // Пробуем найти фильтр, если он уже есть
            $relation = AdFilterValue::where([
                ["advertisement_id", $advertisement_id],
                ["filter_id", $filter->id]
            ])->first();
            // Если значение фильтр есть - то обновляем
            if ($relation) {
                AdFilterValue::where([...$relation->toArray()])
                    ->update(["value" => $value]);
            } else { // Если значения фильтра нет, то добавляем
                AdFilterValue::create([
                    "advertisement_id" => $advertisement_id,
                    "filter_id" => $filter->id,
                    "value" => $value
                ]);
            }
        }
        // Удаляем все фильтры, которые не были перечислены в запросе (т.е. автоматом помеченные как ненужные)
        AdFilterValue::whereNotIn("filter_id", $idsToSave)
            ->where("advertisement_id", $advertisement_id)->delete();
    }
}
