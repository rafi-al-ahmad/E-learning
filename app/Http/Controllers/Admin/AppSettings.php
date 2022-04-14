<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class AppSettings extends Controller
{
    //
    public function showSettingsForm()
    {
        $this->authorize('viewAny', Settings::class);
        $this->authorize('view', Settings::class);

        $settings = Settings::latest()->first();

        $languages = Language::getAllLanguagesNames();

        return view('admin.settings.settings', ['settings' => $settings, 'languages' => $languages]);
    }

    public function updateTimezone(Request $request)
    {
        $this->authorize('update', Settings::class);

        $data = $request->all();

        (Validator::make($data, [
            'city' => ['required'],
            'country' => ['required'],
        ], [], []))->validate();

        try {

            new Carbon($request->city);
            $Settings = Settings::latest()->first()->replicate();
            $Settings->setAttribute('time.timezone', $request->city ) ;
            $Settings->setAttribute('time.country', $request->country ) ;
            $Settings->save();

            // clear settings cache to apply new settings immediately
            Cache::forget('settings');

            return back()->with('success', trans('app.settings.time-zone-updated-successfuly'));
        } catch (\Throwable $th) {

            Log::error($th . '\n' . $request);
            return back()->withErrors(trans('app.settings.time-zone-update-error'));
        }
    }

    public function updateSEO(Request $request)
    {
        $this->authorize('update', Settings::class);

        $data = $request->all();

        (Validator::make($data, [
            'appDescription' => ['required'],
            'tags' => ['required'],
        ], [], []))->validate();


        try {

            $Settings = Settings::latest()->first()->replicate();
            $Settings->appDescription = $request->appDescription;
            $Settings->keyWords = explode(',', $request->tags);
            $Settings->save();

            // clear settings cache to apply new settings immediately
            Cache::forget('settings');

            return back()->with('success', trans('app.settings.SEO-updated-successfuly'));
        } catch (\Throwable $th) {

            Log::error($th . '\n' . $request);
            return back()->withErrors(trans('app.settings.SEO-update-error'));
        }
    }




    public function updateBasics(Request $request)
    {
        $this->authorize('update', Settings::class);

        $request->validate([
            'appName' => 'required|max:20',
            'defaultLanguage' => 'required',
        ]);

        if (isset($request->logo)) {
            $request->validate([
                'logo' => 'required|max:512|file|mimes:icon,svg,png,gif,jpg',
            ]);
        }
        if (isset($request->icon)) {
            $request->validate([
                'icon' => 'required|max:10|file|mimes:icon,svg,png,gif,jpg',
            ]);
        }

        try {

            $Settings = Settings::latest()->first()->replicate();

            if (isset($request->logo)) {
                $logo_path = $request->file('logo')->store('logos');
                $Settings->logo = $logo_path;
            }

            if (isset($request->icon)) {
                $icon_path = $request->file('icon')->store('icons');
                $Settings->favicon = $icon_path;
            }


            $Settings->appName = $request->appName;
            $Settings->defaultLanguage = $request->defaultLanguage;

            $Settings->save();

            // clear settings cache to apply new settings immediately
            Cache::forget('settings');

            return back()->with('success', trans('app.settings.basics-updated-successfuly'));
        } catch (\Throwable $th) {

            Log::error($th . '\n' . $request);
            return back()->withErrors(trans('app.settings.basics-update-error'));
        }
    }


    public function updateMaintenance(Request $request)
    {
        $this->authorize('update', Settings::class);

        $request->validate([
            'maintenanceMessage' => 'required',
            'maintenanceMode' => 'required|in:true,false',
        ]);

        try {

            $Settings = Settings::latest()->first()->replicate();

            $Settings->maintenanceMessage = $request->maintenanceMessage;
            $Settings->maintenanceMode = $request->maintenanceMode;

            $Settings->save();

            // clear settings cache to apply new settings immediately
            Cache::forget('settings');

            return back()->with('success', trans('app.settings.maintenance-mode-updated-successfuly'));
        } catch (\Throwable $th) {

            Log::error($th  . '\n' . $request);
            return back()->withErrors(trans('app.settings.maintenance-mode-update-error'));
        }
    }
}
