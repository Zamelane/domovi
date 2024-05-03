<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "is_active",
        "address_id"
    ];

    // Связи
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function days()
    {
        return $this->hasMany(Day::class);
    }
}
