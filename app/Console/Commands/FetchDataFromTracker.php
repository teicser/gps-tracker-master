<?php

namespace App\Console\Commands;

use App\Http\Services\BeaconService;
use App\Http\Services\GpsService;
use App\Http\Services\TrackerService;
use App\Models\Fetch;
use App\Models\GpsData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchDataFromTracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:gps-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = TrackerService::fetchDataFromTracker();
        $latest_fetch = GpsData::max('gps_timestamp') ?? Carbon::create(2023, 4, 31)->timestamp;
        $data = collect(TrackerService::prepareData($response)['gps'])
            ->where('timestamp', '>', strtotime($latest_fetch));
        $imei_list = $data->pluck('ident')
            ->unique()
            ->values()
            ->map(function ($imei) {
                return GpsService::format_imei($imei);
            });
        $verified_imeis = GpsService::exists($imei_list)->toArray();
        $data = $data->filter(function ($item) use ($verified_imeis) {
            return in_array($item['ident'], $verified_imeis) && array_key_exists('ain.1', $item);
        });
        $gps_devices =  GpsService::get_gps_devices($verified_imeis);
        foreach ($data as $item) {
            $fetch = Fetch::create();
            $gps_device = $gps_devices->where('imei', $item['ident'])->first();
            $gps_data[] = GpsService::store($item, $gps_device, $fetch);
            if (isset($item['ble.beacons']) && !empty($item['ble.beacons'])) {
                foreach ($item['ble.beacons'] as $beacon) {
                    $beacons_data[] = BeaconService::store($beacon, $gps_device, $fetch);
                }
            }
        }
    }
}
