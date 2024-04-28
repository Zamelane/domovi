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
        "valid_until_date"
    ];
}
