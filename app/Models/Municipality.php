<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table = 'municipality'; // Specify the correct table name
    
    protected $fillable = [
        'name',
    ];
}

