<?php

namespace App\Models\Office;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "code",
        "office_id",
        "open_time",
        "close_time"
    ];

    // Связи
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
