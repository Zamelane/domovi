<?php

namespace App\Models\Filters;

use App\Models\Advertisement\Advertisement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdFilterValue extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "filter_id",
        "advertisement_id",
        "value"
    ];

    // Связи
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
