<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class Settings extends Model
{
    use HasFactory;


    public static function getsettings()
    {
        $languages = Cache::remember( 'settings', \Carbon\Carbon::now()->addSeconds(7200), function () {
            return (static::latest()->first());
        });

        return Cache::get('settings');
    }
}
