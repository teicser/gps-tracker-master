<?php

namespace App\Http\Controllers;

use App\Models\GpsData;
use Illuminate\Http\Request;

class GpsDataController extends Controller
{
    public function index()
    {
        $last_knowled_external_powersource_data = GpsData::query()
            ->select(['powersource_voltage', 'gps_timestamp'])
            ->latest('gps_timestamp')
            ->whereNotNull('powersource_voltage')
            ->first('powersource_voltage');

        $gps_data = GpsData::query()
            ->with(['gps_device', 'beacons_data.beacon_device'])
            ->latest('gps_timestamp')
            ->paginate(30);


        $response[] = $gps_data->getCollection()
            ->transform(function ($item) {
                return [
                    'gps_timestamp' => $item->gps_timestamp,
                    'gps_name' => $item->gps_device->name,
                    'gps_imei' => $item->gps_device->imei,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'altitude' => $item->altitude,
                    'analog_input' => $item->analog_input,
                    'x_acceleration' => $item->x_acceleration,
                    'y_acceleration' => $item->y_acceleration,
                    'z_acceleration' => $item->z_acceleration,
                    'request_id' => $item->fetch_id,
                    'powersource_voltage' => $item->powersource_voltage ?? null,
                    'beacons' => $item->beacons_data->map(function ($beacon) {
                        return [
                            'name' => $beacon->name ?? "Not asigned",
                            'imei' => $beacon->beacon_device->imei,
                            'rssi' => $beacon->rssi,
                        ];
                    }),
                ];
            });

        return [
            'data' => $response,
            'last_knowled_external_powersource_data' => [
                'voltage' => $last_knowled_external_powersource_data->powersource_voltage,
                'datetime' => $last_knowled_external_powersource_data->toArray()['gps_timestamp'],
            ]
        ];
    }
}
