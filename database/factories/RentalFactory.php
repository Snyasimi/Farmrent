<?php

namespace Database\Factories;

use App\Models\Rental;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentalFactory extends Factory
{
    protected $model = Rental::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-1 month', '+1 week');
        $duration = $this->faker->numberBetween(4, 72); // hours
        $end = (clone $start)->modify("+{$duration} hours");

        $baseCost = $this->faker->randomFloat(2, 100, 2000);
        $driverRequested = $this->faker->boolean(30);
        $driverCost = $driverRequested ? $this->faker->randomFloat(2, 50, 500) : null;
        $totalCost = $baseCost + ($driverCost ?? 0);

        return [
            'equipment_id'           => Equipment::factory(),
            'farmer_id'              => User::factory(),
            'owner_id'              => User::factory(),
            'rental_start_datetime'  => $start,
            'rental_end_datetime'    => $end,
            'duration_hours'         => $duration,
            'base_cost'              => $baseCost,
            'driver_requested'       => $driverRequested,
            'driver_cost'            => $driverCost,
            'total_cost'             => $totalCost,
            'status'                 => $this->faker->randomElement(['pending','confirmed','active','completed','cancelled']),
            'payment_status'         => $this->faker->randomElement(['pending','paid','refunded']),
            'notes'                  => $this->faker->optional()->sentence(),
        ];
    }
}