<?php

namespace Kjjdion\Laracrud\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class LaracrudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // install files
        $this->publishes([__DIR__ . '/../../resources/stubs/user.stub' => app_path('User.php')], 'install');
        $this->publishes([__DIR__ . '/../../config/laracrud.php' => config_path('laracrud.php')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/public/css.stub' => public_path('css/app.css')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/public/js.stub' => public_path('js/app.js')], 'install');
        $this->publishes([__DIR__ . '/../../public' => public_path('laracrud')], 'install');
        $this->publishes([__DIR__ . '/../../resources/views/layouts' => resource_path('views/vendor/laracrud/layouts')], 'install');
        $this->publishes([__DIR__ . '/../../resources/stubs/routes.stub' => base_path('routes/web.php')], 'install');

        // publish config
        $this->publishes([__DIR__ . '/../../config/laracrud.php' => config_path('laracrud.php')], 'config');

        // fix db string length error, load & publish migrations
        Schema::defaultStringLength(191);
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->publishes([__DIR__ . '/../../database/migrations' => database_path('migrations')], 'migrations');

        // publish public files
        $this->publishes([__DIR__ . '/../../public' => public_path('laracrud')], 'public');

        // load & publish views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laracrud');
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/laracrud')], 'views');

        // alias middleware
        $this->app['router']->aliasMiddleware('guest_role', 'Kjjdion\Laracrud\Http\Middleware\GuestRole');

        // load routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        // gate permissions
        $this->gatePolicies();

        // validator extensions
        $this->validatorExtensions();
    }

    public function register()
    {
        // merge config
        $this->mergeConfigFrom(__DIR__ . '/../../config/laracrud.php', 'laracrud');
    }

    public function gatePolicies()
    {
        Gate::before(function ($user, $role) {
            if ($user->role == $role) {
                return true;
            }
        });
    }

    public function validatorExtensions()
    {
        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, auth()->user()->password);
        }, 'The current password is invalid.');
    }
}