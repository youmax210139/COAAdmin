<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TaskLog;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    /**
     * 最新履歷及查詢結果頁面
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->farm) {
            $products = $products->where('farm', $request->farm);
        }
        if ($request->product) {
            $products = $products->where('product_name', $request->product);
        }
        $products = $products->where('website-enable', 1);
        $products = $products->get();

        $logs = TaskLog::with('product')->whereIn('product_id', $products->pluck('product_id'))->orderby('timestamp', 'desc');
        if (empty($request->query())) {
            $logs = $logs->limit(3);
        }
        $logs = $logs->get();
        $products = $logs->pluck('product')->unique(function ($item) {
            return $item['product_id'];
        });

        $dates = [];
        foreach ($logs as $l) {
            $date = [];
            $date['date'] = Carbon::createFromTimestamp($l->timestamp)->format('Y-m-d');
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
            $dates[] = ['date' => null];
        }
        return view('resumes.index', compact(['logs', 'latest', 'dates', 'year', 'month', 'products']));
    }

    /**
     * 查詢履歷頁面
     *
     * @return void
     */
    public function inquiry()
    {
        $farms = Product::distinct('farm')->orderby('farm')->pluck('farm', 'farm');
        return view('resumes.inquiry', compact(['farms']));
    }

    /**
     * 取得 product_name
     *
     * @param Request $request
     * @return void
     */
    public function product(Request $request)
    {
        $request->validate([
            'farm' => 'required',
        ]);
        return Product::distinct("product_name")->where([
            ['farm', '=', $request->farm],
            ['website-enable', '=', 1],
        ])->pluck('product_name', 'product_name');
    }

    /**
     * 取得驗証資料
     *
     * @param Request $request
     * @return void
     */
    public function validation(Request $request)
    {
        $request->validate([
            'products' => 'required',
        ]);
        $promises = [];
        $client = new Client([
            'base_uri' => env('VALID_API_URL'),
        ]);
        foreach ($request->products as $id) {
            $promise = $client->postAsync('/check_by_product_id', [
                'form_params' => [
                    'product_id' => $id,
                ],
            ]);
            $promises[] = $promise;
        }
        $results = Promise\unwrap($promises);
        $response = [];
        foreach ($results as $res) {
            if ($res->getStatusCode() != 200) {
                continue;
            }
            foreach (json_decode($res->getBody(), true) as $v) {
                $response[$v['log_id']] = $v['result'];
            }
        }
        return $response;
    }
}
