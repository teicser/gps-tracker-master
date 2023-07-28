<?php

namespace App\Http\Services;

use App\Models\GpsData;
use App\Models\GpsDevice;

class GpsService
{
    public static function format_imei($string)
    {
        return preg_replace("/[^A-Za-z0-9]/", "", $string);
    }

    public static function store($data, GpsDevice $gps_device, $fetch)
    {
        $gps_data = GpsData::create([
            'gps_device_id' => $gps_device->id,
            'fetch_id' => $fetch->id,
            'ident' => $data['ident'] ?? null,
            'current_battery' => $data['battery.current'] ?? null,
            'battery_voltage' => $data['battery.voltage'] ?? null,
            'powersource_voltage' => $data['external.powersource.voltage'] ?? null,
            'is_moving' => $data['movement.status'] ?? null,
            'altitude' => $data['position.altitude'] ?? null,
            'direction' => $data['position.direction'] ?? null,
            'latitude' => $data['position.latitude'] ?? null,
            'longitude' => $data['position.longitude'] ?? null,
            'satellites' => $data['position.satellites'] ?? null,
            'analog_input' => $data['ain.1'] ?? null,
            'x_acceleration' => $data['x.acceleration'] ?? null,
            'y_acceleration' => $data['y.acceleration'] ?? null,
            'z_acceleration' => $data['z.acceleration'] ?? null,
            'speed' => $data['position.speed'] ?? null,
            'gps_timestamp' =>  date('Y-m-d H:i:s', $data['timestamp']) ?? null,
            'created_at' => now(),
        ]);
        return $gps_data;
    }

    public static function get_imei($data)
    {
        return self::format_imei($data['ident']);
    }

    public static function get_gps_devices(array $imeis)
    {
        return GpsDevice::whereIn('imei', $imeis)->get();
    }

    public static function exists($imei)
    {
        return GpsDevice::whereIn('imei', $imei)->pluck('imei');
    }
}
