<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;


class CountresTestController extends Controller
{
    public function index(Request $request)
    {
        $countries = new Countries();

        dd ($countries->where('cca2', 'US')->first()->hydrate('timezones')->timezones->first()->zone_name);

        // or calling it statically

        echo Countries::where('cca2', 'IT')->first()->hydrateCurrencies()->currencies->EUR->coins->frequent->first();
    }
}
