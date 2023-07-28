<?php

namespace Database\Seeders;

use App\Models\GpsDevice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        GpsDevice::create(
            [
                'name' => 'FMT100',
                'brand' => 'Teltonika',
                'model' => 'fmt100',
                'imei' => '350612071247462',
                'created_at' => now(),
            ]
        );

        GpsDevice::create(
            [
                'name' => 'Teltonica_2',
                'brand' => 'Teltonika',
                'model' => 'other',
                'imei' => '865413051482445',
                'created_at' => now(),
            ]
        );
    }
}
