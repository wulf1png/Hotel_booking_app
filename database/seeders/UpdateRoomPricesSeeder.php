<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class UpdateRoomPricesSeeder extends Seeder
{
    public function run()
    {
        // Пример: Установить цену для всех номеров
        Room::where('price', 0)->update(['price' => 7500]);

        // Пример: Установить индивидуальные цены
        Room::find(1)->update(['price' => 2000.00]);
        Room::find(2)->update(['price' => 4500.00]);
    }
}
