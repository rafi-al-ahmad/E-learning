<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use PragmaRX\Countries\Package\Countries;


class GeoLocationController extends Controller
{
    public function index(Request $request)
    {
        $time1 = Carbon::now()->format('h:i:s:u');
        $countries = new Countries();


        $time2 = Carbon::now()->format('h:i:s:u');
        echo $time1 . '<br>';
        echo $time2 . '<br>';
        // echo ($countries->where('cca2', 'US')->first()->hydrate('timezones')->timezones->first()->zone_name) . '<br>';
        // echo ($countries->where('cca2', 'US')->first()->hydrate('timezones')->timezones->all()) . '<br>';
        $a = Audience::find('6074a0c4f84700004b000a02');
        $data = Location::get('');
        dd($data->regionCode == $a->getAttribute('rules.geo.geo-state'));
        dd($data->timezone == $a->getAttribute('rules.timezone.timezone-state'));
        dd($a);
        /**
         "rules" => array:2 [▼
            "geo" => array:2 [▼
                "geo-country" => "US"
                "geo-state" => "CA"
            ]
            "timezone" => array:2 [▼
                "timezone-country" => "US"
                "timezone-state" => "America/Los_Angeles"
            ]
        ]





        request()->ip()
         */
    }
}
