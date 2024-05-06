<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "user_id",
        "advertisement_id",
        "stars",
        "description",
        "create_datetime",
        "update_datetime",
        "is_moderation",
        "is_services"
    ];

    // Связи
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
