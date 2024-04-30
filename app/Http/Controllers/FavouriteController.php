<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Models\Advertisement;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function add(Request $request, int $id) {
        if (!$advertisement = Advertisement::find($id))
            throw new NotFoundException("Advertisement");

        Favourite::firstOrCreate([
            "user_id" => auth()->user()->id,
            "advertisement_id" => $id
        ]);

        return response(null, 201);
    }
    public function delete(Request $request, int $id) {
        Favourite::where([
            "user_id" => auth()->user()->id,
            "advertisement_id" => $id
        ])->delete();

        return response(null, 204);
    }
}
