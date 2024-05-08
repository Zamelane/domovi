<?php

namespace App\Models\Advertisement;

use App\Models\Filters\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementTypeFilter extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "filter_id",
        "advertisement_type_id"
    ];

    // Связи
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
    public function advertisement_type()
    {
        return $this->belongsTo(AdvertisementType::class);
    }
}
