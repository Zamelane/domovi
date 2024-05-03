<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "user_id",
        "employee_id",
        "deal_status_id",
        "advertisement_id",
        "sum",
        "percent",
        "create_date",
        "start_date",
        "valid_until_date",
        "address_id"
    ];

    public function setStatus($code) {
        $this->deal_status_id = DealStatus::getByCode($code)->id;
    }

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function deal_status()
    {
        return $this->belongsTo(DealStatus::class);
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
