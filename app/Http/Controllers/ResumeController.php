<?php

namespace App\Http\Controllers;

use App\Models\JobLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

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
        $this->validJobLogs($lists);
        // dd($lists);
        return view('resumes.info', compact(['lists']));
    }

    public function inquery()
    {
        $crops = JobLog::selectRaw('DISTINCT
                (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'作物批號\' ) as harvesting,
                (select serials -> i ->> \'value\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'作物批號\' ) as value
                ')
            ->orderby('harvesting')
            ->pluck('harvesting', 'value');
        $operators = JobLog::selectRaw('DISTINCT
                (select serials -> i ->> \'name\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'茶園場域\' ) as operator,
                (select serials -> i ->> \'value\' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>\'type\')= \'茶園場域\' ) as value
                ')
            ->orderby('operator')
            ->pluck('operator', 'value');
        return view('resumes.inquery', compact(['crops', 'operators']));
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
        if ($request->harvesting) {
            $builder->whereRaw("serials->0 @> '{\"value\": \"$request->harvesting\"}'");
        }
        if ($request->operator) {
            $builder->whereRaw("serials->1 @> '{\"value\": \"$request->operator\"}'");
        }
        $lists = $builder->get();
        $this->validJobLogs($lists);
        return view('resumes.info', compact(['lists']));
    }

    protected function validJobLogs($jobLogs)
    {
        $promises = [];
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('VALID_API_URL'),
        ]);
        $promise = $client->postAsync('/check_by_id', [
            'form_params' => [
                'id' => 194,
            ],
        ]);
        foreach ($jobLogs as $j) {
            $promise = $client->postAsync('/check_by_id', [
                'form_params' => [
                    'id' => $j->id,
                ],
            ]);
            $promise->then(
                function (ResponseInterface $res) use ($j) {
                    $j->validation = json_decode($res->getBody(), true);
                },
                function (RequestException $e) use ($j) {
                    $j->validtion = [ 'result'=> 'false', 'msg'=>$e->getMessage()];
                }
            );
            $promises[] = $promise;
        }
        $results = Promise\settle($promises)->wait();
    }
}
