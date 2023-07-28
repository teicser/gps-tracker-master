<?php

namespace App\Http\Services;

class FlespiService
{
    public static function structure($response)
    {
        $data = collect($response->json());
        $dataFromGps = self::dataFromGps($data);

        return [
            'gps' => $dataFromGps,
        ];
    }

    public function dataFromGps($data)
    {
        $data_result = collect($data['result'])->whereNotNull('ident');
        return $data_result;
    }

    public function dataFromBeacons($data)
    {
        $beacons = $data
            ->collapse()
            ->filter(function ($value) {
                if (isset($value['ble.beacons'])) {
                    return count($value['ble.beacons']) > 0;
                }
            })
            ->map(function ($item) {
                return $item['ble.beacons'];
            })
            ->collapse()
            ->unique('id')
            ->values();

        return $beacons;
    }
}
