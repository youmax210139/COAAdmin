<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::group([
    'middleware' => 'setlocale',
], function () {
    #首頁
    Route::get('/', 'HomeController@index')->name('homes.index');
    #最新履歷及查詢結果頁面
    Route::get('/resumes', 'ResumeController@index')->name('resumes.index');
    #履歷查詢表單頁面
    Route::get('/resumes/inquiry', 'ResumeController@inquiry')->name('resumes.inquiry');
    #取得 product_name
    Route::get('/resumes/product', 'ResumeController@product')->name('resumes.product');
    #取得 good_name
    Route::get('/resumes/good', 'ResumeController@good')->name('resumes.good');
    #取得驗証資料
    Route::get('/resumes/validation', 'ResumeController@validation')->name('resumes.validation');
    #Demo
    Route::get('/neo4j/{image}', 'Neo4jController@view')->name('neo4j.view');
    #二維碼
    Route::get('/qrcode', function () {
        return view('qrcode');
    })->name('qrcode.show');
    #语言
    Route::get('/locales/{locale}', 'LocaleController@update')->name('locales.update');
});
