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
Route::get('/', 'HomeController@index')->name('homes.index');
Route::get('/resumes', 'ResumeController@index')->name('resumes.index');
#履歷查詢頁面
Route::get('/resumes/inquiry', 'ResumeController@inquiry')->name('resumes.inquiry');
#取得 product_name
Route::get('/resumes/product', 'ResumeController@product')->name('resumes.product');

Route::post('/resumes/search', 'ResumeController@search')->name('resumes.search');
Route::get('/resumes/search', 'ResumeController@search')->name('resumes.search');
Route::get('/qrcode', function () {
    return view('qrcode');
})->name('qrcode.show');
