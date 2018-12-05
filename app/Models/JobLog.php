<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLog extends Model
{
    protected $table = 'jobs_joblog';
    protected $casts = [
        'definition' => 'array',
        'serials' => 'array',
    ];
}