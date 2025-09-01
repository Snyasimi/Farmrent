<?php

namespace App\Services;

use App\Models\{Equipment};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EquipmentService
{


    public function queryEquipment($equipmentName)
    {
        //maybe clean using regex
        //$equipmentName = 

        $result =  Equipment::with('owner')->where('name','like',"%{$equipmentName}%")->paginate(10);

        return $result;

    }



    public function getOwnedEquipment($user)
    {
        $owner_id = $user->id;
        
        return Equipment::with('category')
            ->where('owner_id', $owner_id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function createEquipment(array $data, $user)
    {
    // Store image and prepare image paths array

    $imagePath = $data['image']->store('equipment_images', 'public');

    $images = $imagePath;

    // Prepare data for DB

    $equipmentData = [
        'name'                  => $data['name'],
        'description'           => $data['description'] ?? null,
        'category_id'           => $data['category_id'],
        'hourly_rate'           => $data['hourly_rate'] ?? null,
        'daily_rate'            => $data['daily_rate'],
        'weekly_rate'           => $data['weekly_rate'] ?? null,
        'includes_driver'       => $data['includes_driver'] ?? false,
        'driver_additional_cost'=> $data['driver_additional_cost'] ?? null,
        'availability_status'   => $data['availability_status'] ?? 'available',
        'location'              => $data['location'] ?? null,
        'image'                => $images,
    ];

    // Create equipment for the given user (assuming rentals() is the equipment relation)
    return $user->equipment()->create($equipmentData);

    }

    public function getListedEquipment()
    {
        $equipment = Equipment::with('owner')->paginate(10);
        
        return $equipment; 

    }
}