<?php

namespace App\Http\Controllers;

use App;

class LocaleController extends Controller
{
    public function update($locale = 'zhtw')
    {
        if (!in_array($locale, config('app.locales'))) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        return back();
    }
}
