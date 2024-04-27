<?php

namespace App\Models;

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

    // Связи
    public function street()
    {
        return $this->belongsTo(Street::class);
    }
}
