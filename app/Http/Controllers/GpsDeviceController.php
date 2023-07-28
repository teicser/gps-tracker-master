<?php

namespace App\Http\Controllers;

use App\Models\GpsDevice;
use Illuminate\Http\Request;

class GpsDeviceController extends Controller
{
    public function index()
    {
        $response = GpsDevice::query()
            ->with(['gps_data.beacons_data'])
            ->latest()
            ->get();

        return $response;
    }
}
