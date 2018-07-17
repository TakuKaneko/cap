<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * 会社が取得しているAPIの一覧を取得する
     */
    public function apis()
    {
        return $this->hasMany('App\Models\Api');
    }
}
