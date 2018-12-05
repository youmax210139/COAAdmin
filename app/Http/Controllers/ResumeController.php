<?php

namespace App\Http\Controllers;

use App\Models\JobLog;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index()
    {
        $lists = JobLog::selectRaw('id,
            to_char(client_side_timestamp, \'YYYY-MM-DD HH24:MI:SS\') as date,
            definition->>\'name\' as task,
            serials->1->>\'name\' as operator,
            serials->2->>\'name\' as tool,
            serials->0->>\'name\' as haversting,
            serials->0->>\'value\' as tea_id,
            serials->2->>\'type\' as explain
        ')
        ->orderby('created_at', 'desc')
        ->limit(3)
        ->get();
        return view('resumes.index', compact(['lists']));
    }

    public function inquery()
    {
        $crops = JobLog::selectRaw('DISTINCT serials->0->\'value\' as value, serials->0->\'name\' as name')->pluck('name', 'value');
        $locations = JobLog::selectRaw('DISTINCT serials->1->\'value\' as value, serials->1->\'name\' as name')->pluck('name', 'value');
        return view('resumes.inquery', compact(['crops', 'locations']));
    }

    public function search(Request $request)
    {
        $lists = JobLog::selectRaw('id,
                  to_char(client_side_timestamp, \'YYYY-MM-DD HH24:MI:SS\') as date,
                  definition->>\'name\' as task,
                  serials->1->>\'name\' as operator,
                  serials->2->>\'name\' as tool,
                  serials->0->>\'name\' as haversting,
                  serials->0->>\'value\' as tea_id,
                  serials->2->>\'type\' as explain
                  ')
            ->whereRaw("serials->0 @> '{\"value\": $request->crop}' and serials->1 @> '{\"value\":$request->location}'")
            ->orderby('created_at')
            ->get();

        return view('resumes.index', compact(['lists']));
    }
}
