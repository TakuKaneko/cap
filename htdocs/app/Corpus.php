<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corpus extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
