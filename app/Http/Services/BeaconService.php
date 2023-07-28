<?php

namespace App\Http\Services;

use App\Models\BeaconData;
use App\Models\BeaconDevice;
use App\Models\Fetch;

class BeaconService
{
    public function format_imei($string)
    {
        return preg_replace("/[^A-Za-z0-9]/", "", $string);
    }

    public static function store($beacon, $gps_device, $fetch)
    {
        $beacon_imei = self::format_imei($beacon['id']);
        $beacon_device = BeaconDevice::where('imei', $beacon_imei)->first();
        if (is_null($beacon_device)) {
            $beacon_device = BeaconDevice::create([
                'imei' => $beacon_imei,
                'gps_device_id' => $gps_device->id,
            ]);
        }
        $beacon_data = BeaconData::create([
            'beacon_device_id' => $beacon_device->id,
            'fetch_id' => $fetch->id,
            'rssi' => $beacon['rssi'],
        ]);
        return $beacon_data;
    }

    public function latestDataByGpsDevice()
    {
        $gps_imei = '350612071247462';
        $latest_fetch = Fetch::latest()->first();
        $beacons = BeaconDevice::query()
            ->whereHas('gps.gps_data', function ($query) use ($gps_imei, $latest_fetch) {
                $query->where('imei', $gps_imei)
                    ->where('fetch_id', $latest_fetch->id);
            })
            ->whereHas('beacons_data', function ($query) use ($latest_fetch) {
                $query->where('fetch_id', $latest_fetch->id);
            })
            ->with(['beacons_data' => function ($query) use ($latest_fetch) {
                $query->where('fetch_id', $latest_fetch->id);
            }])
            ->get();

        $response = $beacons->map(function ($beacon) {
            return $beacon->beacons_data->map(function ($item) use ($beacon) {
                return [
                    'name' => $beacon->name ?? 'Not defined',
                    'imei' => $beacon->imei,
                    'rssi' => $item->rssi,
                ];
            });
        });
        return $response->collapse();
    }
}
