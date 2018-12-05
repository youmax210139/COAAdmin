<?php

namespace App\Http\Controllers;

use App\Models\JobLog;

class ResumeController extends Controller
{
    public function index()
    {
        return view('resumes.index');
    }

    public function inquery()
    {
        $crops = JobLog::selectRaw('DISTINCT serials->0->\'value\' as value, serials->0->\'name\' as name')->pluck('name', 'value');
        $locations = JobLog::selectRaw('DISTINCT serials->1->\'value\' as value, serials->1->\'name\' as name')->pluck('name', 'value');
        return view('resumes.inquery', compact(['crops', 'locations']));
    }
}
