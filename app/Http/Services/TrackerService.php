<?php

namespace App\Http\Services;

use App\Http\Interfaces\TrackerInterface;
use Illuminate\Support\Facades\Http;

class TrackerService implements TrackerInterface
{
    public static function fetchDataFromTracker()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json, text/plain, */*',
            'Authorization' => config('tracker.token')
        ])
            ->get(config('tracker.url') . 'channels/' . config('tracker.channel') . '/messages', [
                'data' => '{
                    "limit_count": 250
                }'
            ]);

        return $response;
    }

    public static function prepareData($response)
    {
        $data = FlespiService::structure($response);
        return $data;
    }
}
