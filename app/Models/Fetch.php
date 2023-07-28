<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fetch extends Model
{
    use HasFactory;

    public function beacons_data(): HasMany
    {
        return $this->hasMany(BeaconData::class);
    }

    public function gps_data(): HasMany
    {
        return $this->hasMany(GpsData::class);
    }
}
