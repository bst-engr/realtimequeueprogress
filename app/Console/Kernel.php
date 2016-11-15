<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $phone = rand(1111111111, 9999999999);
            $contactId = rand(1,80);
            DB::table('contacts')->where('contact_id','=', $contactId)->update(array('phone_number'=> $phone));
            $return = DB::table('contacts')->where('contact_id','=', $contactId)->first();
            $return = json_decode(json_encode($return), true);
            $pusher = App::make('pusher');
            $pusher->trigger(   
                            'contacts-channel',
                            'contact-updated', 
                            $return
                        );
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
