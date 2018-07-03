<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corpus extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
