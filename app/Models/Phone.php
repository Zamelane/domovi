<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    // Заполняемые поля
    protected $fillable = [
        'phone'
    ];

    /** Связи **/
    // Phone <--> User
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
