<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'number_of_cots',
        'early_juvenile',
        'juvenile',
        'sub_adult',
        'adult',
        'late_adult',
        'activity_type',
        'observer_category',
        'municipality',
        'barangay',
        'date_of_sighting',
        'time_of_sighting',
        'photo',
    ];
}
