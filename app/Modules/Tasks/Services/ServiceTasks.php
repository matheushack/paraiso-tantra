<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/01/19
 * Time: 07:38
 */

namespace App\Modules\Tasks\Services;


use App\Modules\Tasks\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB as Capsule;
use Illuminate\Support\Facades\Storage;

class ServiceTasks
{
    public function list()
    {
        return Tasks::all();
    }

    public function store(Request $request)
    {
        try {
            Capsule::transaction(function () use ($request) {
                Tasks::truncate();

                foreach($request->input('job') as $data) {
                    $task = new Tasks();
                    $task->command = $data['command'];
                    $task->schedule = $data['schedule'];
                    $task->week = (!empty($data['week']) ? json_encode($data['week']) : null);

                    if (!$task->save())
                        throw new \Exception('Não foi possível salvar as tarefas. Por favor, tente mais tarde!');
                }

                Cache::pull(env('SCHEDULE_KEY_CACHE', 'schedule'));
            });

            return [
                'message' => 'Tarefas configurados com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }

    public function database()
    {
        try {
            Artisan::call('backup:clean');
            Artisan::call('backup:run', ['--only-db' => true]);

            return [
                'message' => 'Backup efetuado com sucesso!',
                'save' => true
            ];
        }catch(\Exception $e){
            return [
                'message' => $e->getMessage(),
                'save' => false
            ];
        }
    }
}