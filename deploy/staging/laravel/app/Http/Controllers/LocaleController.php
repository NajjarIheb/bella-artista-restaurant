<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    /**
     * Store the chosen locale in the session and redirect back.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(Request $request, $locale)
    {
        if (! in_array($locale, ['fr', 'en', 'ar'], true)) {
            $locale = config('app.locale');
        }

        $request->session()->put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}
