<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_TIME, 'pt_BR.UTF-8');
        
        Paginator::useBootstrap();

        $this->bootBladeIncludes();
        $this->bootValidation();
        $this->bootBladeIfs();
    }

    /**
     * Estruturas de condições customizadas do blade
     * 
     * @return void
     */
    private function bootBladeIfs()
    {
        Blade::if('role', function($role) {
            return (auth()->check() && auth()->user()->hasRole($role));
        });
    }

    private function bootBladeIncludes()
    {
        Blade::include('layouts.components.modal', 'modal');
        Blade::include('layouts.components.forms.radios', 'radios');
    }

    private function bootValidation()
    {
        Validator::extend('cpf', 'App\Rules\Cpf@passes');
        Validator::extend('cnpj', 'App\Rules\Cnpj@passes');
        Validator::extend('name', 'App\Rules\Name@passes');
    }
}
