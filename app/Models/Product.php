<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $translatable = ['product_name', 'farm'];

    public function taskLogs()
    {
        return $this->hasMany('App\Models\TaskLog', 'product_id', 'product_id');
    }

    public function goods()
    {
        return $this->belongsToMany('App\Models\Good', 'product_goods', 'product_id', 'goods_id');
    }
}
