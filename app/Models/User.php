<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // Add any additional fields used by your app below:
        'phone',
        'role', // e.g. 'farmer' or 'renter'
        // Add more fields as required by your application
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //protected $fillable = ['name','email','password','role','phone'];

    // Relationships

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'owner_id');
    }


    public function rentals(): HasMany
    {
        // As a farmer
        return $this->hasMany(Rental::class, 'farmer_id');
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class, 'renter_id');
    }

    public function drivers()
    {
        return $this->hasOne(Driver::class,'renter_id');
    }
}