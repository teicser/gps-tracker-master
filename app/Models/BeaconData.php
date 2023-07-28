<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeaconData extends Model
{
    use HasFactory;

    protected $fillable = [
        'beacon_device_id',
        'fetch_id',
        'rssi',
        'created_at',
        'updated_at',
    ];

    protected $cast = [
        'beacon_device_id' => 'integer',
        'fetch_id' => 'integer',
        'rssi' => 'integer',
    ];

    public function fetch(): BelongsTo
    {
        return $this->belongsTo(Fetch::class);
    }

    public function beacon_device(): BelongsTo
    {
        return $this->belongsTo(BeaconDevice::class);
    }
}
