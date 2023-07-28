<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class GpsDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'imei',
        'created_at',
        'updated_at',
    ];

    protected $cast = [
        'name' => 'string',
        'brand' => 'string',
        'model' => 'string',
        'imei' => 'string',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    public function gps_data(): HasMany
    {
        return $this->hasMany(GpsData::class);
    }

    public function beacons(): HasMany
    {
        return $this->hasMany(BeaconDevice::class);
    }

    public function beacons_data(): HasManyThrough
    {
        return $this->hasManyThrough(BeaconData::class, BeaconDevice::class);
    }
}
