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
        /**
         * Define custom Blade Stuff
         */
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
        Blade::component('components/form-select-multiple', 'formselectmultiple');
        Blade::component('components/form-textarea', 'formtextarea');
        Blade::component('components/form-editor', 'formeditor');
        Blade::component('components/form-checkbox', 'formcheckbox');
        Blade::component('components/form-media', 'formmedia');
        Blade::component('components/form-list', 'formlist');
        Blade::component('components/form-products', 'formproducts');
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
