<?php

use Illuminate\Support\Facades\Config;
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


// Auth::routes();


Route::group([

    'prefix' => 'admin',
    'middleware' => ['setAdminUser', 'AuthenticateAdminsSession'],

],  function () {

    Config::set('auth.defines', 'admin');

    Route::get('job', function()
    {

        $job = (new App\Jobs\SendMail('jsgv@skjbv.com', new App\Mail\ClosedAccountMail()));
        dispatch($job);
        echo 'done';
    });

    Route::get('Support', 'App\Http\Controllers\Admin\AdminsManagerController@support')->name('admin.ContactSupport');
    // login routes
    Route::get('login', 'App\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'App\Http\Controllers\Admin\Auth\LoginController@login');

    //register new admin routes
    // Route::get('register/{token}/{email}', 'App\Http\Controllers\Admin\Auth\RegisterController@showRegistrationForm')->name('admin.register');
    // Route::post('register', 'App\Http\Controllers\Admin\Auth\RegisterController@register');

    //forgot password Routes
    Route::get('password/reset', 'App\Http\Controllers\Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'App\Http\Controllers\Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'App\Http\Controllers\Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'App\Http\Controllers\Admin\Auth\ResetPasswordController@reset')->name('admin.password.update');

    Route::group(['middleware' => ['admin:admin']], function () {

        // email verifiction routes
        Route::get('email/verify', 'App\Http\Controllers\Admin\Auth\VerificationController@show')->name('admin.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Admin\Auth\VerificationController@verify')->name('admin.verification.verify');
        Route::post('email/resend', 'App\Http\Controllers\Admin\Auth\VerificationController@resend')->name('admin.verification.resend');


        //admin logout route
        Route::post('logout', 'App\Http\Controllers\Admin\Auth\LoginController@logout')->name('admin.logout');

        //closed account route
        Route::get('account/closed', 'App\Http\Controllers\Admin\UsersManagerController@ShowClosedAccountView')->name('admin.closedAccount');


        Route::group(['middleware' => []], function () {

            //admin definition routes
            Route::get('define', 'App\Http\Controllers\Admin\Auth\RegisterController@showAdminDefinitionForm')->name('admin.define');
            Route::post('define', 'App\Http\Controllers\Admin\Auth\RegisterController@invitation');

            Route::get('users', 'App\Http\Controllers\Admin\UsersManagerController@getUsers')->name('admin.Users');;
            Route::get('users/account/details/{id}', 'App\http\controllers\Admin\UsersManagerController@accountDetails')->name('admin.UserAccountDetails');
            Route::get('users/account/edit/{id}', 'App\http\controllers\Admin\UsersManagerController@editAcountGET')->name('admin.UsersAccountEdit');
            Route::post('users/account/edit', 'App\http\controllers\Admin\UsersManagerController@editAcountPOST')->name('admin.updateAccountDetails');
            Route::post('users/account/edit/password', 'App\http\controllers\Admin\UsersManagerController@UpdateAcountPassword')->name('admin.updateAccountPassword');
            Route::post('account/close', 'App\Http\Controllers\Admin\UsersManagerController@closeAccount')->name('admin.CloseUserAccount');
            Route::post('account/update/avatar', 'App\Http\Controllers\Admin\UsersManagerController@updateAvatar')->name('admin.updateAccountAvatar');
            Route::post('account/activate', 'App\Http\Controllers\Admin\UsersManagerController@activateAccount')->name('admin.ActivateUserAccount');
            Route::get('user-data', 'App\Http\Controllers\Admin\UsersManagerController@getCustomFilterData');

            Route::get('languages', 'App\Http\Controllers\Admin\LanguagesManagerController@languages')->name('admin.languages');
            Route::get('languages/details/{id}', 'App\Http\Controllers\Admin\LanguagesManagerController@languagesDetails')->name('admin.languageDetails');
            Route::get('languages/edit/{id}', 'App\Http\Controllers\Admin\LanguagesManagerController@languageEditGET')->name('admin.languageEdit');
            Route::post('languages/edit', 'App\Http\Controllers\Admin\LanguagesManagerController@languageEditPOST')->name('admin.languageEditPOST');

            Route::get('languages/create', 'App\Http\Controllers\Admin\LanguagesManagerController@addLanguage')->name('admin.languageAdd');
            Route::post('language/define', 'App\Http\Controllers\Admin\LanguagesManagerController@defineNewLanguage')->name('admin.defineLanguage');

            Route::get('files/manage', 'App\Http\Controllers\Admin\FilesManagerController@show')->name('admin.manageFiles');

            Route::get('roles', 'App\Http\Controllers\Admin\RolesController@roles')->name('admin.showRoles');
            Route::get('roles/details/{id}', 'App\Http\Controllers\Admin\RolesController@details')->name('admin.roleDetails');
            Route::get('roles/edit/{id}', 'App\Http\Controllers\Admin\RolesController@edit')->name('admin.roleEdit');
            Route::post('roles/edit', 'App\Http\Controllers\Admin\RolesController@update')->name('admin.roleUpdate');
            Route::get('roles/create', 'App\Http\Controllers\Admin\RolesController@newRole')->name('admin.roleCreate');
            Route::post('roles/create', 'App\Http\Controllers\Admin\RolesController@create');
            Route::post('roles/delete', 'App\Http\Controllers\Admin\RolesController@delete')->name('admin.deleteRole');


            Route::get('app/settings', 'App\Http\Controllers\Admin\AppSettings@showSettingsForm')->name('admin.appSettings');
            Route::post('app/settings/timezone', 'App\Http\Controllers\Admin\AppSettings@updateTimezone')->name('admin.settings.updateTimezone');
            Route::post('app/settings/basics', 'App\Http\Controllers\Admin\AppSettings@updateBasics')->name('admin.settings.updateBasics');
            Route::post('app/settings/maintenance', 'App\Http\Controllers\Admin\AppSettings@updateMaintenance')->name('admin.settings.updateMaintenanceMode');
            Route::post('app/settings/seo', 'App\Http\Controllers\Admin\AppSettings@updateSEO')->name('admin.settings.updateSEO');

            Route::get('announcements', 'App\Http\Controllers\Admin\AnnouncementController@announcements')->name('admin.announcement');
            Route::get('announcements/create', 'App\Http\Controllers\Admin\AnnouncementController@newAnnouncement')->name('admin.announcement.new');
            Route::post('announcements/create', 'App\Http\Controllers\Admin\AnnouncementController@create')->name('admin.announcement.create');
            Route::get('announcements/edit/{id}', 'App\Http\Controllers\Admin\AnnouncementController@edit')->name('admin.announcement.edit');
            Route::post('announcements/edit', 'App\Http\Controllers\Admin\AnnouncementController@editPost')->name('admin.announcement.edit.post');
            Route::post('announcements/delete', 'App\Http\Controllers\Admin\AnnouncementController@delete')->name('admin.announcement.delete');
            Route::get('announcements/details/{id}', 'App\Http\Controllers\Admin\AnnouncementController@details')->name('admin.announcement.view');


            Route::get('audiences', 'App\Http\Controllers\Admin\AudienceController@index')->name('admin.audiences');
            Route::get('audiences/create', 'App\Http\Controllers\Admin\AudienceController@createGet')->name('admin.audience.create');
            Route::post('audiences/create', 'App\Http\Controllers\Admin\AudienceController@create')->name('admin.audience.create');
            Route::get('audiences/view/{id}', 'App\Http\Controllers\Admin\AudienceController@details')->name('admin.audience.view');
            Route::get('audiences/update/{id}', 'App\Http\Controllers\Admin\AudienceController@updateGet')->name('admin.audience.edit');
            Route::post('audiences/update', 'App\Http\Controllers\Admin\AudienceController@update')->name('admin.audience.edit.post');
            Route::post('audiences/delete', 'App\Http\Controllers\Admin\AudienceController@delete')->name('admin.audience.delete');


            Route::get('reports', 'App\Http\Controllers\Admin\ReportsController@index')->name('admin.reports');
            Route::get('reports/create', 'App\Http\Controllers\Admin\ReportsController@createGet')->name('admin.report.create');
            Route::post('reports/create', 'App\Http\Controllers\Admin\ReportsController@create')->name('admin.report.create');
            Route::get('reports/view/{id}', 'App\Http\Controllers\Admin\ReportsController@details')->name('admin.report.view');
            Route::get('reports/update/{id}', 'App\Http\Controllers\Admin\ReportsController@updateGet')->name('admin.report.edit');
            Route::post('reports/update', 'App\Http\Controllers\Admin\ReportsController@update')->name('admin.report.edit.post');
            Route::post('reports/delete', 'App\Http\Controllers\Admin\ReportsController@delete')->name('admin.report.delete');


            Route::get('get-address-from-ip',[App\Http\Controllers\GeoLocationController::class, 'index']);
            Route::get('get-country-test',[App\Http\Controllers\CountresTestController::class, 'index']);

            Route::get('test', 'App\Http\Controllers\Admin\TestController@test')->name('admin.test');
            Route::get('/', function () {
                return view('admin.home');
            })->name('admin.home');
        });
    });
});
