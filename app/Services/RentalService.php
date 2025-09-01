<?php

namespace App\Services;

use App\Models\{User,Equipment,Rental};
use Illuminate\Support\Collection;
use Carbon\Carbon;

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

    public function getRentalRequests($user)
    {

        $data = Rental::with(['farmer','owner'])->where('owner_id',$user->id)->get();

        return $data;

    }

    public function getRentedOutEquipment($user)

    {
    return \App\Models\Rental::with(['equipment', 'farmer'])
        ->where('owner_id', $user->id)
        ->where('farmer_id', '!=', $user->id)
        ->orderByDesc('created_at')
        ->get();

    }

    public function getLeasedEquipment($user)
    {

        $equipment = Rental::with(['equipment','owner','farmer'])->where('owner_id',$user->id)->get();

        return $equipment;

    }

    public function getMyRentals($user)
    {
        return Rental::with(['equipment', 'owner'])
            ->where('farmer_id', $user->id)
            ->where('status','active')
            ->Where('status','pending')
            ->orderByDesc('created_at')
            ->get();
    }

    public function rentEquipment($user,$equipmentData)
    {
        $equipment = Equipment::find($equipmentData['equipment_id']);

        $charges = array('daily' => $equipment->daily_rate, 
                         'hourly' => $equipment->hourly_rate, 
                         'weekly' => $equipment->weekly_rate
    
                        );

        $totalCost = $equipment->driver_additional_cost + ( $charges[ $equipmentData['rental_type'] ] * $equipmentData['duration'] );

        $now = Carbon::now();

        $rental = Rental::create(
            [
                'equipment_id' => $equipment->id,
                'farmer_id' => $user->id,
                'owner_id' => $equipment->owner->id,
                'rental_start_datetime'=> $now,
                'rental_end_datetime' => $now,
                'duration_hours' => $equipmentData['duration'],
                'base_cost' => $equipment->daily_rate,
                'driver_cost' => $equipment->driver_additional_cost,
                'total_cost' => $totalCost,
                'created_at' => $now
            ]
        );

        if($rental)
        {
            return true;
        }
        return false;

    }
}