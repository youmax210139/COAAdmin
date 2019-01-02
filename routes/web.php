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
Route::get('/resumes/inquiry', 'ResumeController@inquiry')->name('resumes.inquiry');
Route::get('/resumes/harvesting', 'ResumeController@harvesting')->name('resumes.harvesting');

Route::post('/resumes/search', 'ResumeController@search')->name('resumes.search');
Route::get('/resumes/search', 'ResumeController@search')->name('resumes.search');
Route::get('/qrcode', function () {
    return view('qrcode');
})->name('qrcode.show');
