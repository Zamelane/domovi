<?php

namespace App\Models\Complaint;

use App\Models\Advertisement\Advertisement;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "user_id",
        "advertisement_id",
        "description",
        "is_review"
    ];

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
