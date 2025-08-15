<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'renter_id',
        'name',
        'phone',
        'license_number',
        'experience_years',
        'availability_status',
    ];

    // Relationships

    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }
}