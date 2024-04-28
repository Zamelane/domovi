<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "city_id",
        "name"
    ];

    /*
     * Возвращает улицу по полям из входящего запроса.
     */
    public static function streetByRequest()
    {
        $city = City::cityByRequest();

        if (!$city)
            return null;

        $credentials = request(["street_id", "street"]);

        if (array_key_exists("street_id", $credentials))
            return Street::find($credentials["street_id"]);

        return Street::firstOrCreate([
            "name" => $credentials["street"],
            "city_id" => $city->id
        ]);
    }

    // Связи
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
