<?php

use Illuminate\Database\Seeder;
use App\Modules\Rooms\Models\Rooms;
use App\Modules\Units\Models\Units;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms[] = [
            'name' => 'Sala 1',
            'unity_id' => Units::orderBy('created_at', 'desc')->first()->id,
            'is_active' => 1

        ];

        foreach($rooms as $room){
            $roomCount = Rooms::where('name', '=', $room['name'])
                ->where('unity_id', '=', $room['unity_id'])
                ->count();

            if($roomCount == 0)
                Rooms::create($room);
        }
    }
}
