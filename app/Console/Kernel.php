<?php

namespace App\Console;

use App\Modules\Tasks\Models\Tasks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

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
//        if(!Cache::has(env('SCHEDULE_KEY_CACHE', 'schedule'))){
//            Cache::rememberForever(env('SCHEDULE_KEY_CACHE', 'schedule'), function() use($schedule){
//                return Tasks::all();
//            });
//        }
//
//        $tasks = Cache::get(env('SCHEDULE_KEY_CACHE', 'schedule'));
//
//        if(!empty($tasks)) {
//            $tasks->each(function ($item) use ($schedule) {
//                $task = $schedule->command($item->command);
//
//                if(!empty($item->schedule)) {
//                    list($hour, $minute) = explode(':', $item->schedule);
//                    $cron = "{$minute} {$hour} * * ";
//                }else{
//                    $cron = "* * * * ";
//                }
//
//                if(!empty($item->week)) {
//                    $weeks = json_decode($item->week);
//                    $weekMatrix = [];
//
//                    foreach($weeks as $week){
//                        switch ($week) {
//                            case 'seg':
//                                $weekMatrix[] = 1;
//                                break;
//                            case 'ter':
//                                $weekMatrix[] = 2;
//                                break;
//                            case 'qua':
//                                $weekMatrix[] = 3;
//                                break;
//                            case 'qui':
//                                $weekMatrix[] = 4;
//                                break;
//                            case 'sex':
//                                $weekMatrix[] = 5;
//                                break;
//                            case 'sab':
//                                $weekMatrix[] = 6;
//                                break;
//                            case 'dom':
//                                $weekMatrix[] = 0;
//                                break;
//                        }
//                    }
//
//                    if(count($weekMatrix) == 7){
//                        $task->cron($cron.'*');
//                    }else{
//                        $cronWeeks = implode(',', $weekMatrix);
//                        $task->cron($cron.$cronWeeks);
//                    }
//                }else{
//                    $task->cron($cron.'*');
//                }
//            });
//        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
