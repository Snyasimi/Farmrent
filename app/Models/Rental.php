<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'farmer_id',
        'owner_id',
        'rental_start_datetime',
        'rental_end_datetime',
        'duration_hours',
        'base_cost',
        'driver_requested',
        'driver_cost',
        'total_cost',
        'status',
        'payment_status',
        'notes',
    ];

    // Relationships

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}