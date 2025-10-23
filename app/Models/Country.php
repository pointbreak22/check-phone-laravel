<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_code',
        'country_name',
        'phone_code',
        'min_length',
        'max_length',
        'regex_pattern'
    ];

    protected $casts = [
        'min_length' => 'integer',
        'max_length' => 'integer',
    ];
}
