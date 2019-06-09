<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TaskLog;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->farm) {
            $products = $products->where('farm', $request->farm);
        }
        if ($request->product) {
            $products = $products->where('product_name', $request->product);
        }

        $products = $products->get();

        $logs = TaskLog::with('product')->whereIn('product_id', $products->pluck('product_id'))->orderby('timestamp', 'desc');
        if (empty($request->query())) {
            $logs = $logs->limit(3);
        }
        $logs = $logs->get();
        // $this->validJobLogsByCheckIds($lists);
        $dates = [];
        foreach ($logs as $l) {
            $date = [];
            $date['date'] = Carbon::createFromTimestamp($l->timestamp)->format('Y-m-d');
            $l->date = $l->scrollId = $date['date'];
            $date['badge'] = true;
            $dates[] = $date;
        }
        if (!empty($dates)) {
            $arr = explode("-", $dates[0]['date']);
            $year = $arr[0];
            $month = $arr[1];
        } else {
            $year = $month = null;
            $dates[] = ['date' => null];
        }
        return view('resumes.index', compact(['logs', 'latest', 'dates', 'year', 'month', 'products']));
    }

    public function inquiry()
    {
        $farms = Product::distinct('farm')->orderby('farm')->pluck('farm', 'farm');
        return view('resumes.inquiry', compact(['farms']));
    }

    public function product(Request $request)
    {
        return Product::distinct("product_name")->where('farm', $request->farm)->pluck('product_name', 'product_name');
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
