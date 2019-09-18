<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use Translatable;
    protected $primaryKey = 'goods_id';
    protected $translatable = ['goods_name', 'farm'];
}
