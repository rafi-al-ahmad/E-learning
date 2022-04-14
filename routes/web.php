<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', function () {
    return view('welcome');
});//->middleware('verified');

Auth::routes(['verify' => true]);

Route::group([
    // 'middleware' => 'guest',
    // 'prefix'     => $config->getRoutePrefix(),
    'namespace'  => 'App\Http\Controllers',
], function (){

    Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
});
// email verifiction routes
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');



Route::get('local/set/{language}', 'App\Http\Controllers\Admin\LanguagesManagerController@setUserLangCookie')->name('set-local');






Route::get('admin/config', function () {
    // $rr = [];
    // $p =Permission::all();
    // foreach ($p as $key => $value) {
    //     $rr[]= new MongoDB\BSON\ObjectID($value->_id);
    // }
    // $r =Role::find('605d1b24391a000064003e44');
    // $r->permissions= $rr;
    // $r->save();
    // Config::set('app.name', 'mysinglelue');
    // dd (Config::get('app'));
});
