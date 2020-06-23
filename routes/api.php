<?php

use App\Models\TaskLog;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
Route::post('/check_by_product_id', function (Request $request) {
    $logs = TaskLog::where('product_id', $request->product_id)->get();
    $response = [];
    foreach ($logs as $l) {
        $response[] = [
            'log_id' => $l->log_id,
            'result' => (bool) random_int(0, 1),
        ];
    }
    return $response;
});
