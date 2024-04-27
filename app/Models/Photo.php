<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "advertisement_id"
    ];

    protected $hidden = [
        "id",
        "advertisement_id"
    ];
}
