<?php
/**
 * Laravel 5 Masgsm SMS
 * @license MIT License
 * @author Ufuk GÖKKURT <ufuk.gokkurt@gmail.com>
 * @link http://ufukgokkurt.com
 *
 */

namespace Ufukgokkurt\Masgsm;


use Illuminate\Support\ServiceProvider;

class MasgsmServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/masgsm.php' => config_path('masgsm.php'),
        ], 'config');
    }

    public function register()
    {
            $this->app->singleton('masgsm',function ($app){
                return new Masgsm($app);
            });
    }



}