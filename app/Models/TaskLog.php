<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    use Translatable;

    protected $table = 'task_log';
    protected $primaryKey = 'log_id';

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'product_id');
    }

    public function getDateAttribute()
    {
        return Carbon::createFromTimestamp($this->timestamp)->toDateTimeString();
    }
}
