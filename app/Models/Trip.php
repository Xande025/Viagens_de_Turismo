<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin',
        'destination',
        'departure_time',
        'arrival_time',
        'vehicle_id',
        'driver_id',
        'passenger_count',
        'price',
        'status',
        'description',
        'observations'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'decimal:2'
    ];

    /**
     * Get the vehicle for this trip
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the driver for this trip
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Check if trip is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if trip is in progress
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }
}
