<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\Favourites\FavouriteResource;
use App\Models\Advertisement\Advertisement;
use App\Models\Advertisement\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function add(Request $request, int $id)
    {
        if (!$advertisement = Advertisement::find($id))
            throw new NotFoundException("Advertisement");

        Favourite::firstOrCreate([
            "user_id" => auth()->user()->id,
            "advertisement_id" => $id
        ]);

        return response(null, 201);
    }
    public function delete(Request $request, int $id)
    {
        Favourite::where([
            "user_id" => auth()->user()->id,
            "advertisement_id" => $id
        ])->delete();

        return response(null, 204);
    }
    public function list()
    {
        $user = auth()->user();
        return response([
            "advertisements" => FavouriteResource::collection(Favourite::where('user_id', $user->id)->simplePaginate(15))
        ], 200);
    }
}
