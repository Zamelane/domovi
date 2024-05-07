<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressRequest;
use App\Http\Requests\Address\CityRequest;
use App\Http\Requests\Address\StreetRequest;
use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Streets\StreetResource;
use App\Models\Address;
use App\Models\City;
use App\Models\Street;

class AddressController extends Controller
{
    public function get(AddressRequest $request)
    {
        return response(AddressResource::make(Address::addresByRequest()));
    }

    public function getCity(CityRequest $request)
    {
        $cities = City::where("name", "LIKE", "%$request->city%")
            ->limit(10)
            ->get();
        return response($cities, 200);
    }

    public function getStreet(StreetRequest $request)
    {
        $query = Street::where("streets.name", "LIKE", "%$request->street%");

        if ($request->city_id)
            $query->where("city_id", $request->city_id);
        else if ($request->city)
            $query->join("cities", function ($city) use ($request) {
                $city->on("cities.id", "=", "streets.city_id")
                    ->where("cities.name", "LIKE", "$request->city%");
            });

        $streets = $query->limit(10)->select('streets.*')->get();
        return response(StreetResource::collection($streets), 200);
    }
}
