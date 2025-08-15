<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition()
    {
        return [
            'renter_id' => User::factory(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'license_number' => $this->faker->optional()->bothify('DL-########'),
            'experience_years' => $this->faker->optional()->numberBetween(1, 30),
            'availability_status' => $this->faker->randomElement(['available', 'unavailable']),
        ];
    }
}