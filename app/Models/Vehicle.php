<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'identification_name',
        'plate',
        'model',
        'brand',
        'year',
        'capacity',
        'bus_type',
        'status',
        'description',
        'has_internet',
        'has_wc',
        'has_fridge',
        'has_heater',
        'has_video'
    ];

    protected $casts = [
        'has_internet' => 'boolean',
        'has_wc' => 'boolean',
        'has_fridge' => 'boolean',
        'has_heater' => 'boolean',
        'has_video' => 'boolean'
    ];

    /**
     * Get all trips for this vehicle
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Check if vehicle is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}
