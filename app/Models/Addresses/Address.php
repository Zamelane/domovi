<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "street_id",
        "house",
        "structure",
        "building",
        "apartament"
    ];

    /*
     * Возвращает адрес по полям из входящего запроса.
     */
    public static function addresByRequest()
    {
        $street = Street::streetByRequest();

        if (!$street)
            return null;

        $credentials = request(["house", "structure", "apartament", "building"]);

        return Address::firstOrCreate([
            ...$credentials,
            "street_id" => $street->id
        ]);
    }

    // Связи
    public function street()
    {
        return $this->belongsTo(Street::class);
    }
}
