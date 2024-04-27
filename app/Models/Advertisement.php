<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "user_id",
        "advertisement_id",
        "address_id",
        "advertisement_type_id",
        "transaction_type",
        "area",
        "count_rooms",
        "measurement_type",
        "is_active",
        "is_moderated",
        "is_deleted",
        "is_archive",
        "cost"
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
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function advertisement_type()
    {
        return $this->belongsTo(AdvertisementType::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    public function ad_filter_values()
    {
        return $this->hasMany(AdFilterValue::class);
    }
}
