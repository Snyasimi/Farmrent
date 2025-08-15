<?php

namespace App\Services;

use App\Models\User;
use App\Models\Rental;
use Illuminate\Support\Collection;

class RentalService
{
      
    public function getDashboardData(User $renter): array
{
    $now = now();

    // 1. Get all equipment for this renter (with category and rental count)
    $equipment = $renter->equipment()
        ->with(['category'])
        ->withCount('rentals')
        ->get()
        ->map(function ($item) use ($now) {
            // Mark if this equipment is currently rented
            $item->is_rented = $item->rentals()
                ->where('rental_start_datetime', '<=', $now)
                ->where('rental_end_datetime', '>=', $now)
                ->whereIn('status', ['confirmed', 'active'])
                ->exists();
            return $item;
        });

    $equipmentIds = $equipment->pluck('id');

    // 2. All rentals for this renter's equipment (history, for stats)
    $allRentals = \App\Models\Rental::whereIn('equipment_id', $equipmentIds)
        ->with(['farmer', 'equipment'])
        ->get();

    // 3. Current rentals for this renter's equipment (ongoing only)
    $currentRentals = $allRentals->filter(function ($rental) use ($now) {
        return $rental->rental_start_datetime <= $now
            && $rental->rental_end_datetime >= $now
            && in_array($rental->status, ['confirmed', 'active']);
    })->values();

    // 4. Completed rentals (past, completed bookings)
    $completedRentals = $allRentals->filter(function ($rental) use ($now) {
        return $rental->rental_end_datetime < $now
            && $rental->status === 'completed';
    })->values();

    // 5. Dashboard stats
    $totalEquipment = $equipment->count();
    $totalRentalsAllTime = $allRentals->count();
    $currentlyRentedCount = $currentRentals->count();

    return [
        'equipment'             => $equipment,
        'allRentals'            => $allRentals,
        'currentRentals'        => $currentRentals,
        'completedRentals'      => $completedRentals,
        'totalEquipment'        => $totalEquipment,
        'totalRentalsAllTime'   => $totalRentalsAllTime,
        'currentlyRentedCount'  => $currentlyRentedCount,
    ];
}

    public function getRentedOutEquipment($user)
{
    return \App\Models\Rental::with(['equipment', 'farmer'])
        ->where('owner_id', $user->id)
        ->where('farmer_id', '!=', $user->id)
        ->orderByDesc('created_at')
        ->get();
}

    public function getMyRentals($user)
    {
        return Rental::with(['equipment', 'renter'])
            ->where('farmer_id', $user->id)
            ->where('status','active')
            ->orderByDesc('created_at')
            ->get();
    }
}