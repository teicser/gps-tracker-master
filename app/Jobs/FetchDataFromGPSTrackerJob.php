<?php

namespace App\Jobs;

use App\Http\Services\BeaconService;
use App\Http\Services\GpsService;
use App\Http\Services\TrackerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchDataFromGPSTrackerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo 'Executing';
        $response = TrackerService::fetchDataFromTracker();
        $data = TrackerService::prepareData($response);
        $gps_imei = GpsService::get_imei($data);
        if (!GpsService::exist($gps_imei)) {
            return 'GPS device imei not found.';
        }
        $gps_device = GpsService::get_gps_device($gps_imei);
        $gps_data = GpsService::store($data['gps'], $gps_device);
        $beacons_data = [];
        foreach ($data['beacon'] as $beacon) {
            $beacons_data[] = BeaconService::store($beacon, $gps_device);
        }
        return [
            'gps' => $gps_data,
            'beacons' => $beacons_data,
        ];
    }
}
