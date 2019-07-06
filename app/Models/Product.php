<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $translatable = ['product_name'];

    public function taskLogs()
    {
        return $this->hasMany('App\Models\TaskLog', 'product_id', 'product_id');
    }
}
