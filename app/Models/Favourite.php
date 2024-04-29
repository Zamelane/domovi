<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Заполняемые поля
    protected $fillable = [
        'advertisement_id',
        'user_id'
    ];

    // Связи
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function advertisement() {
        return $this->belongsTo(Advertisement::class);
    }
}
