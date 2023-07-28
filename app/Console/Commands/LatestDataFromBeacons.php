<?php

namespace App\Console\Commands;

use App\Models\BeaconDevice;
use App\Models\Fetch;
use Illuminate\Console\Command;

class LatestDataFromBeacons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beacon:latest-data';

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
    public function handle($gps_imei)
    {
        dd('this command is disabled');
        $latest_fetch = Fetch::latest()->first();
        $beacons = BeaconDevice::query()
            ->whereHas('gps_device.gps_data', function ($query) use ($gps_imei, $latest_fetch) {
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
        dd($response->collapse()->toJson());
    }
}
