<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate',
        'model',
        'brand',
        'year',
        'capacity',
        'status',
        'description'
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
