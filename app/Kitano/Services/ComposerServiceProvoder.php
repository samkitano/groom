<?php

namespace App\Kitano\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvoder extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $curr_native = config('laravellocalization.supportedLocales.'.$locale.'.native');

            $view->with(compact('locale'))
                 ->with(compact('curr_native'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}