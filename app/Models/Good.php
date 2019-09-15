<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use Translatable;
    protected $translatable = ['goods_name', 'farm'];
}
