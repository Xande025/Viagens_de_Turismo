<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'cnh',
        'cnh_category',
        'cnh_expiry',
        'phone',
        'email',
        'status'
    ];

    protected $casts = [
        'cnh_expiry' => 'date'
    ];

    /**
     * Get all trips for this driver
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Check if driver is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if CNH is valid
     */
    public function isValidCnh()
    {
        return $this->cnh_expiry > now();
    }
}
