<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "name"
    ];

    /*
     * Возвращает город по полю из входящего запроса.
     */
    public static function cityByRequest()
    {
        $credentials = request(["city_id", "city"]);

        if (array_key_exists("city_id", $credentials))
            return City::find($credentials["city_id"]);

        return City::firstOrCreate(["name" => $credentials["city"]]);
    }
}
