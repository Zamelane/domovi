<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenYouException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Advertisement\AdvertisementCreateRequest;
use App\Http\Resources\Advertisements\AdvertisementResource;
use App\Models\Address;
use App\Models\Advertisement;
use App\Models\City;
use App\Models\Photo;
use App\Models\Street;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function create(AdvertisementCreateRequest $request) {
        $currUser = auth()->user();
        //$advertisement_type_id = AdvertisementType::find($request->advertisement_type_id);
        $cityId = City::firstOrCreate(['name' => $request->city])->id;
        $streetId = Street::firstOrCreate(['name' => $request->street, 'city_id' => $cityId])->id;
        $addressId = Address::firstOrCreate([
            'street_id' => $streetId,
            ...request(['house', 'structure', 'building', 'apartament'])
        ])->id;

        $advertisement = Advertisement::create([
            ...$request->all(),
            'advertisement_type_id' => $request->advertisement_type_id,
            'address_id' => $addressId,
            'user_id' => $currUser->id
        ]);

        $files = $request->file('photos') ?? [];

        foreach ($files as $file) {
            $fileExt = $file->getClientOriginalExtension();
            $fileHash = md5_file($file->getRealPath());

            $imageName = "$fileHash.$fileExt";
            $path = "uploads/$fileExt/";

            if (!Storage::exists($path.$imageName))
                $file->move  ($path,$imageName );

            $image = Photo::firstOrCreate(["name" => $imageName, "advertisement_id" => $advertisement->id]);
        }

        return response(AdvertisementResource::make($advertisement), 201);
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
