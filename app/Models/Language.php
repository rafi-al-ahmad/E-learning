<?php

namespace App\Models;
use  Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Language extends Model
{
    use HasFactory;


    protected $fillable = [
        'payload',

    ];

    protected $payloadFields = [];



    public static function getlang($code)
    {
        $lang = Cache::remember( 'lang-'.$code, \Carbon\Carbon::now()->addSeconds(7200), function () use ($code) {
            return (static::where('code', '=', $code)->first());
        });


        return Cache::get('lang-'.$code);
    }


    function getLangPayloadFields($array, $parentKey = '')
    {
        // dd($array);
        foreach ($array as $key => $value) {
            if (is_array($value)) {

                $this->getLangPayloadFields($value, ($parentKey?$parentKey .".":"") . $key);
            } else {
                 array_push ($this->payloadFields, $parentKey . '.' . $key);
            }
        }
        return $this->payloadFields;
    }


    public function getDir()
    {
        return $this->direction;
    }

    public static function getAllLanguagesNames()
    {
        $languages = Cache::remember( 'languages', \Carbon\Carbon::now()->addSeconds(7200), function () {
            return (static::select('code', 'name')->get());
        });

        return Cache::get('languages');
    }
}
