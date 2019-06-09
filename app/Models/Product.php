<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    public function taskLogs()
    {
        return $this->hasMany('App\Models\TaskLog', 'product_id', 'product_id');
    }
}
