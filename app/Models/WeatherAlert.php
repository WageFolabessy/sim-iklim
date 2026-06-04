<?php

namespace App\Models;

use Database\Factories\WeatherAlertFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherAlert extends Model
{
    /** @use HasFactory<WeatherAlertFactory> */
    use HasFactory;

    protected $fillable = [
        'level',
        'title',
        'area',
        'body',
    ];
}
