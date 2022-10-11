<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FormStoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once \app_path() . '/Helpers/FormStore.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
