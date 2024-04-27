<?php

namespace App\Models;

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AdvertisementTypeFilter extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "filter_id",
        "advertisement_type_id"
    ];

    public static function getFilters($advertisement_type_id)
    {
        $relationsFilters = AdvertisementTypeFilter::where("advertisement_type_id", $advertisement_type_id)->get();
        foreach ($relationsFilters as $relation) {
            $filter = $relation->filter;
            switch ($filter->type) {
                case "write_number":
                    $filtersRules["filters.{$filter->code}"] = "required|decimal:0,2|min:0|max:3000.00";
                    break;
                case "summer_number":
                    $filtersRules["filters.{$filter->code}"] = "required|integer|min:0|max:10";
                    break;
                case "write_text":
                    $filtersRules["filters.{$filter->code}"] = "required|string|min:2|max:32";
                    break;
                case "select":
                    $in = "";
                    foreach ($filter->filter_values as $v)
                        $in .= ($in != "" ? "," : "") . $v->value;
                    if ($in != "")
                        $filtersRules["filters.{$filter->code}"] = "required|in:$in";
                    break;
            }
        }
        return $filtersRules ?? null;
    }

    public static function saveFiltersToAd(int $advertisement_id, array $filters, $r)
    {
        foreach ($filters as $key => $value) {
            $keys = explode(".", $key);
            $keyFormate = $keys[count($keys) - 1];
            $filter = Filter::where("code", $keyFormate)->first();
            if (!$filter)
                continue;
            $relation = AdFilterValue::where([
                ["advertisement_id", $advertisement_id],
                ["filter_id", $filter->id]
            ])->first();
            if ($relation) {
                $relation->value = $r[$key];
                $relation->save();
            } else {
                AdFilterValue::create([
                    "advertisement_id" => $advertisement_id,
                    "filter_id" => $filter->id,
                    "value" => $r[$key]
                ]);
            }
        }
    }

    // Связи
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
    public function advertisement_type()
    {
        return $this->belongsTo(AdvertisementType::class);
    }
}
