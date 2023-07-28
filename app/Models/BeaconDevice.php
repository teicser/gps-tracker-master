<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeaconDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'imei',
        'gps_device_id',
        'created_at',
        'updated_at',
    ];

    protected $cast = [
        'name' => 'string',
        'brand' => 'string',
        'model' => 'string',
        'imei' => 'string',
        'gps_device_id' => 'integer',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    public function gps_device(): BelongsTo
    {
        return $this->belongsTo(GpsDevice::class);
    }


    public function beacons_data(): HasMany
    {
        return $this->hasMany(BeaconData::class);
    }
}
