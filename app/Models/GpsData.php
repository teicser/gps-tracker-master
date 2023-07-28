<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class GpsData extends Model
{
    use HasFactory;

    protected $fillable = [
        'gps_device_id',
        'fetch_id',
        'current_battery',
        'battery_voltage',
        'powersource_voltage',
        'analog_input',
        'x_acceleration',
        'y_acceleration',
        'z_acceleration',
        'is_moving',
        'altitude',
        'direction',
        'latitude',
        'longitude',
        'satellites',
        'speed',
        'gps_timestamp',
        'ident'
    ];

    protected $cast = [
        'gps_device_id' => 'integer',
        'ident' => 'decimal',
        'fetch_id' => 'integer',
        'current_battery' => 'decimal',
        'battery_voltage' => 'decimal',
        'powersource_voltage' => 'decimal',
        'is_moving' => 'boolean',
        'altitude' => 'decimal',
        'direction' => 'decimal',
        'latitude' => 'string',
        'longitude' => 'string',
        'satellites' => 'string',
        'speed' => 'decimal',
        'analog_input' => 'decimal',
        'x_acceleration' => 'decimal',
        'y_acceleration' => 'decimal',
        'z_acceleration' => 'decimal',
        'gps_timestamp' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function fetch(): BelongsTo
    {
        return $this->belongsTo(Fetch::class);
    }

    public function gps_device(): BelongsTo
    {
        return $this->belongsTo(GpsDevice::class);
    }

    public function beacons_data(): HasManyThrough
    {
        return $this->hasManyThrough(BeaconData::class, Fetch::class, 'id', 'fetch_id');
    }
}
