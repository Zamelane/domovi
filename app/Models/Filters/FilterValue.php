<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterValue extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "filter_id",
        "value"
    ];

    // Связи
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
