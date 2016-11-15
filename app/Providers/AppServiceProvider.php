<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use \App\Models\Contacts;

class LaravelLoggerProxy {
    public function log( $msg ) {
        Log::info($msg);
    }
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $pusher = $this->app->make('pusher');
        $pusher->set_logger( new LaravelLoggerProxy() );
        Contacts::saving(function($record){
            $pusher = App::make('pusher');
            $pusher->trigger(   
                            'contacts-channel',
                            'contact-updated', 
                            array('contact'=> $record)
                        );
            var_dump($record);

        });
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
