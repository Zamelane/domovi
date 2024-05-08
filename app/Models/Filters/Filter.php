<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "code",
        "type"
    ];

    public function filter_values()
    {
        return $this->hasMany(FilterValue::class);
    }
}
