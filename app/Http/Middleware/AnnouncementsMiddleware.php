<?php

namespace App\Http\Middleware;

use App\Models\Announcement;
use App\Models\Audience;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Stevebauman\Location\Facades\Location;

class AnnouncementsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->ip());

        $announcements = $this->getAnnouncements();
        dd($announcements);
        Cookie::queue('announcements', json_encode($announcements), 20);
        dd(json_decode(request()->cookie('announcements'), true));
        if (!empty($announcements)) {

            if ($cookie = request()->cookie('announcements')) {

                $this->checkAnnouncementsInCookie($announcements, $cookie);

                if ($data = Location::get($request->ip())) {

                    $a = Audience::find('6074a0c4f84700004b000a02');
                    dd($data->regionCode == $a->getAttribute('rules.geo.geo-state'));
                    dd($data->timezone == $a->getAttribute('rules.timezone.timezone-state'));
                }

                $cookieAnnouncement = json_decode(request()->cookie('announcements'), true);
                dd('is set cookie');
            } else {
            }
            // dd(Cookie::get());
            // $cookie = cookie('announcements', $announcements, 20);
            // request()->cookie($cookie);

            // return back()->cookie($cookie);


        } else if (request()->cookie('announcements')) {
            $this->forgetCookie('announcements');
        }

        // return back();
        // dd('end');

        return $next($request);
    }

    public function forgetCookie($name)
    {
        Cookie::queue(Cookie::forget($name));
    }

    public function getAnnouncements()
    {
        return Announcement::getActiveAnnouncements()->all();
    }

    public function checkAnnouncementInCookie($announcements, $cookie)
    {

        foreach ($announcements as $key => $value) {
            # code...
        }
    }
}
