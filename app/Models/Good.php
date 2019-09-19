<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use Translatable;
    protected $primaryKey = 'goods_id';
    protected $translatable = ['goods_name', 'farm'];
    protected $appends = ['product_name'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_goods', 'goods_id', 'product_id');
    }

    public function getProductNameAttribute()
    {
        return $this->goods_name;
    }
}
