<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run()
    {
        Room::create(['description' => 'Одноместный номер. Уютный номер с одной двуспальной кроватью, телевизором и Wi-Fi.']);
        Room::create(['description' => 'Двухместный номер. Две комнаты, рассчитанные на проживание семьи из 4 человек.']);
        Room::create(['description' => 'Люкс. Просторный номер с балконом и видом на море. Включает мини-бар и ванную с джакузи.']);
    }
}
