<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Mongodb\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "announcement",
        "announcementDatetimeRange",
        "announcementStartDate",
        "announcement-background-color",
        "border-raduce",
        "announcement-text",
        "announcementEndDate",
        "audience",
        "description",
        "closeable",
        "hasTimer",
        "timer-background-color",
        "timer-font-color",
        "with-seconds",
        "with-minutes",
        "with-hours",
        "with-days",
        "border-radius",
    ];

    public static function getActiveAnnouncements()
    {
        // Cache::forget('announcements');
        $announcement = Cache::remember('announcements', Carbon::now()->addSeconds(7200), function () {
            return (static::where('announcementEndDate', '>', Carbon::now())->get());
        });

        return Cache::get('announcements');
    }
}
