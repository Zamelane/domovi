<?php

namespace App\Models\Deals;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealStatus extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "code",
        "description"
    ];

    public static function getByCode(string $code)
    {
        return DealStatus::where('code', $code)->first();
    }
}
