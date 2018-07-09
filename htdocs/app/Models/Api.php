<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    /**
     * APIに紐づくコーパスレコードを取得
     */
    public function corpuses()
    {
        return $this->belongsToMany('App\Models\Corpus');
    }

}
