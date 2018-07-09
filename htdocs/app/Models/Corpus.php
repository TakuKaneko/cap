<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corpus extends Model
{
    /**
     * このコーパスを所有するAPIを取得
     */
    public function apis()
    {
        return $this->belongsToMany('Api');
    }
}
