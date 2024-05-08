<?php

namespace App\Models\Office;

use App\Models\Addresses\Address;
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
