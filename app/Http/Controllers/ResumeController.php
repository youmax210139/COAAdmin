<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\JobLog;
use App\Models\TeaInfo;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        $latest = !session()->has('lists');
        $info = session('info');
        $lists = session('lists') ?? JobLog::selectRaw("
            id,
            url,
            to_char(client_side_timestamp, 'YYYY-MM-DD HH24:MI:SS') as date,
            (select serials -> i ->> 'name' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type')= '作物批號' ) as harvesting,
            definition ->> 'name' as task,
            (select serials -> i ->> 'name' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type')= '茶園場域' ) as operator,
            (select serials -> i ->> 'name' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type' != '作物批號' AND serials->i->>'type' != '茶園場域')) as tool,
            serials->0->>'value' as tea_id,
            (select serials -> i ->> 'type' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type' != '作物批號' AND serials->i->>'type' != '茶園場域')) as explain
            ")
            ->orderby('created_at', 'desc')
            ->limit(3)
            ->get();
        $this->validJobLogsByCheckIds($lists);
        $dates = [];
        foreach ($lists as $l) {
            $date = [];
            $date['date'] = Carbon::parse($l->date)->format('Y-m-d');
            $l->scrollId = $date['date'];
            $date['badge'] = true;
            $dates[] = $date;
        }
        if (!empty($dates)) {
            $arr = explode("-", $dates[0]['date']);
            $year = $arr[0];
            $month = $arr[1];
        } else {
            $year = $month = null;
            $dates[] = ['date'=>null];
        }
        // dd($lists);
        return view('resumes.info', compact(['lists', 'latest', 'info', 'dates', 'year', 'month']));
    }

    public function inquiry()
    {
        $farms = TeaInfo::selectRaw("DISTINCT farm")->orderby('farm')->pluck('farm', 'farm');
        return view('resumes.inquiry', compact(['farms']));
    }

    public function harvesting(Request $request)
    {
        return TeaInfo::distinct("harvesting")->where('farm', $request->farm)->pluck('harvesting', 'harvesting');
    }

    public function search(Request $request)
    {
        $builder = JobLog::selectRaw("
                    id,
                    url,
                    to_char(client_side_timestamp, 'YYYY-MM-DD HH24:MI:SS') as date,
                    (select serials -> i ->> 'name' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type')= '作物批號' ) as harvesting,
                    definition ->> 'name' as task,
                    (select serials -> i ->> 'name' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type')= '茶園場域' ) as operator,
                    (select serials -> i ->> 'name' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type' != '作物批號' AND serials->i->>'type' != '茶園場域')) as tool,
                    serials->0->>'value' as tea_id,
                    (select serials -> i ->> 'type' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type' != '作物批號' AND serials->i->>'type' != '茶園場域')) as explain
                  ")
            ->orderby('created_at', 'desc');
        if ($request->harvesting) {
            $builder->whereRaw("
                (select serials -> i ->> 'name' from generate_series(0,jsonb_array_length(serials)-1) as gs (i) where (serials->i->>'type')= '作物批號') = '$request->harvesting'
                ");
            $info = TeaInfo::where('harvesting', $request->harvesting)->first();
        }

        $lists = $builder->get();
        $this->validJobLogsByCheckIds($lists);
        return redirect()->route('resumes.index')->with(['lists' => $lists, 'info' => $info ?? null]);
    }

    protected function validJobLogsByCheckId($jobLogs)
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
                    $j->validtion = [
                        'id' => $j->id,
                        'result' => false,
                        'dataHash' => '',
                        'msg' => $e->getMessage(),
                    ];
                }
            );
            $promises[] = $promise;
        }
        $results = Promise\settle($promises)->wait();
    }

    protected function validJobLogsByCheckIds($jobLogs)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('VALID_API_URL'),
        ]);
        try {
            $res = $client->post('/check_by_ids', [
                'form_params' => [
                    'ids' => json_encode($jobLogs->pluck('id')->toArray()),
                ],
            ]);
            $res = json_decode($res->getBody(), true);
        } catch (Exception $e) {
            $res = [];
        }

        $jobLogs->each(function ($item, $key) use ($res) {
            $item->validation = [
                'id' => $item->id,
                'result' => false,
                'dataHash' => '',
            ];

            foreach ($res as $key => $val) {
                if ($val['id'] == $item->id) {
                    $item->validation = $val;
                    break;
                }
            }
        });
    }
}
