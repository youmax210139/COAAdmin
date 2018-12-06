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
        (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'作物批號\' ) as harvesting,
        definition ->> \'name\' as task,
        (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'茶園場域\' ) as operator,
        (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\' != \'作物批號\' AND serials->i->>\'type\' != \'茶園場域\')) as tool,
        serials->0->>\'value\' as tea_id,
        (select serials -> i ->> \'type\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\' != \'作物批號\' AND serials->i->>\'type\' != \'茶園場域\')) as explain
        ')
            ->orderby('created_at', 'desc')
            ->limit(3)
            ->get();
        return view('resumes.info', compact(['lists']));
    }

    public function inquery()
    {
        $crops = JobLog::selectRaw('DISTINCT serials->0->\'value\' as value, serials->0->\'name\' as name')->pluck('name', 'value');
        $locations = JobLog::selectRaw('DISTINCT serials->1->\'value\' as value, serials->1->\'name\' as name')->pluck('name', 'value');
        return view('resumes.inquery', compact(['crops', 'locations']));
    }

    public function search(Request $request)
    {
        $builder = JobLog::selectRaw('id,
                  to_char(client_side_timestamp, \'YYYY-MM-DD HH24:MI:SS\') as date,
                  (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'作物批號\' ) as harvesting,
                  definition ->> \'name\' as task,
                  (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'茶園場域\' ) as operator,
                  (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\' != \'作物批號\' AND serials->i->>\'type\' != \'茶園場域\')) as tool,
                  serials->0->>\'value\' as tea_id,
                  (select serials -> i ->> \'type\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\' != \'作物批號\' AND serials->i->>\'type\' != \'茶園場域\')) as explain
                  ')
        //->whereRaw("serials->0 @> '{\"value\": $request->crop}' and serials->1 @> '{\"value\":$request->location}'")
            ->orderby('created_at');
        if ($request->crop) {
            $builder->whereRaw("serials->0 @> '{\"value\": $request->crop}'");
        }
        if ($request->location) {
            $builder->whereRaw("serials->1 @> '{\"value\": $request->location}'");
        }
        $lists = $builder->get();
        return view('resumes.info', compact(['lists']));
    }
}
