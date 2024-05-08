<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementType extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "is_commercial"
    ];
}
