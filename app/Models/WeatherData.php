<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'date', 'data'];

    public function city()
    {
        return $this->hasOne(City::class);
    }
}
