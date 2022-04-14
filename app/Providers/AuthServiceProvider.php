<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\User;
use App\Models\PublicAlert;
use App\Models\Role;
use App\Models\Settings;
use App\Policies\LanguagePolicy;
use App\Policies\PublicAlertPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingsPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        PublicAlert::class => PublicAlertPolicy::class,
        Language::class => LanguagePolicy::class,
        Role::class => RolePolicy::class,
        Settings::class => SettingsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-settings', function ($user) {
            return $user->isAdmin;
        });

        Gate::define('access-dashboard', function (User $user) {
            return $user->hasPermission('access-dashboard');
        });

        Gate::define('browse-dashboard', function (User $user) {
            return $user->hasPermission('access-dashboard');
        });


        Gate::define('browse-files', function (User $user) {
            return $user->hasPermission('browse-files')
                ? Response::allow()
                : Response::deny('You do not have permission to brows files.');
        });

        Gate::define('add-files', function (User $user) {
            return $user->hasPermission('add-files')
                ? Response::allow()
                : Response::deny('You do not have permission to create or upload files.');
        });

        Gate::define('delete-files', function (User $user) {
            return $user->hasPermission('delete-files')
                ? Response::allow()
                : Response::deny('You do not have permission to delete files.');
        });

        Gate::define('view-files', function (User $user) {
            return $user->hasPermission('view-files')
                ? Response::allow()
                : Response::deny('You do not have permission to view files.');
        });

        Gate::define('edit-files', function (User $user) {
            return $user->hasPermission('edit-files')
                ? Response::allow()
                : Response::deny('You do not have permission to edit files.');
        });
    }
}
