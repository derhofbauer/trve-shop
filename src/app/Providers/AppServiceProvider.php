<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('permitted', function ($permission) {
           return Auth::user()->role->$permission;
        });

        Blade::component('components/module', 'module');
        Blade::component('components/card', 'card');
        Blade::component('components/form', 'form');
        Blade::component('components/form-group', 'formgroup');
        Blade::component('components/form-tab', 'formtab');
        Blade::component('components/table', 'table');
        Blade::component('components/form-input', 'forminput');
        Blade::component('components/form-select', 'formselect');
        Blade::component('components/form-textarea', 'formtextarea');
        Blade::component('components/form-editor', 'formeditor');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
