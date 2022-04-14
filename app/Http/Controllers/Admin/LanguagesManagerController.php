<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LanguagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class LanguagesManagerController extends Controller
{
    //

    protected $Names = array();



    public function languages(LanguagesDataTable $lang)
    {
        $this->authorize('viewAny', Language::class);

        return $lang->render('admin.languages.languages');
    }

    public function languagesDetails($id)
    {
        // language::getlang('en');
        // app()->setLocale('ar');
        // dd(app()->getLocale());
        // dd(langLines('en','auth'));

        $this->authorize('view', Language::class);

        $language = Language::find($id);

        if ($language) {
            return view('admin.languages.language-details', ['language' => $language]);
        } else {
            return redirect(route('admin.languages'))->withErrors(trans('app.language.not-found'));
        }
    }

    public function languageEditGET($id)
    {
        $this->authorize('view', Language::class);

        $lang = Language::find($id);

        if ($lang) {
            return view('admin.languages.language-edit', ['lang' => $lang]);
        } else {
            return redirect(route('admin.languages'))->withErrors(trans('app.language.not-found'));
        }
    }

    public function languageEditPOST(Request $request)
    {
        $this->authorize('update', Language::class);

        $data = ($request->all());

        (Validator::make($data, array_merge([
            'id' => ['required'],
            'name' => ['required'],
            'code' => ['required'],
            'direction' => ['required', 'in:LTR,RTL'],

        ], $this->getLanguagesLinesValidator('en')), [], []))->validate();

        $lang = Language::find($data['id']);

        $data = $this->convertToMongoSyntax($data);
        try {
            if ($lang){

                foreach ($data as $key => $value) {
                if ($key == "_token") {
                    continue;
                }

                $lang->$key = $value;
            }
            $lang->save();

            // clear languages cache to apply languages updates immediately
            Cache::forget('languages');
            Cache::forget('lang-'.$request->code);

            return back()->with('success', trans('app.language.updated-successfuly'));
        }else {
            return redirect(route('admin.languages'))->withErrors(trans('app.language.not-found'));
        }

        } catch (\Throwable $th) {
            return back()->withErrors( $th->getMessage());

        }
    }


    public function addLanguage()
    {
        $this->authorize('create', Language::class);

        $englishlang = Language::where('code', '=', 'en')->first();

        if ($englishlang) {
            return view('admin.languages.language-add', ['englishlang' => $englishlang]);
        } else {
            return redirect(route('admin.languages'))->withErrors(trans('app.language.not-found'));
        }
    }

    public function defineNewLanguage(Request $request)
    {
        $this->authorize('create', Language::class);

        $data = ($request->all());

        (Validator::make($data, array_merge([
            'name' => ['required'],
            'code' => ['required'],
            'direction' => ['required', 'in:LTR,RTL'],

        ], $this->getLanguagesLinesValidator('en')), [], []))->validate();

        $data = $this->convertToMongoSyntax($data);
        try {

            $lang = new Language();

            foreach ($data as $key => $value) {
                if ($key == "_token") {
                    continue;
                }

                $lang->$key = $value;
            }
            $lang->save();

            // clear languages cache to apply languages updates immediately
            Cache::forget('languages');

            return back()->with('success', trans('app.language.created-successfuly'));

        } catch (\Throwable $th) {
            return back()->with('errors', $th->getMessage());

        }
    }

    private function getLanguagesLinesValidator($code)
    {
        $validateArray = [];
        $lang = Language::where('code', '=', $code)->first();
        if ($lang) {
            $PayloadField = $lang->getLangPayloadFields($lang->payload);
            foreach ($PayloadField as $value) {
                $validateArray['payloadKeyDotE' . str_replace('.', 'KeyDotE', $value)] = ['required'];
            }
        }
        return ($validateArray);
    }

    private function convertToMongoSyntax($array)
    {
        $MongoDBArray = [];

        if ($array) {
            foreach ($array as $key => $value) {

                $MongoDBArray[str_replace('KeyDotE', '.', $key)] = $value;
            }
        }
        return ($MongoDBArray);
    }

    public function setUserLangCookie(Request $request)
    {
        $cookie = cookie('language', $request->language, 2628000);

        return back()->cookie($cookie);
    }
}
