<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{EquipmentCategory,User};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
    // {
    //     protected $model = \App\Models\Equipment::class;
    // }
    public function definition()
    {
        return [
            'owner_id' => User::factory(),
            'name' => $this->faker->word() . ' Tractor',
            'description' => $this->faker->sentence(),
            'category_id' => EquipmentCategory::factory(),
            'hourly_rate' => $this->faker->randomFloat(2, 500, 3000),
            'daily_rate' => $this->faker->randomFloat(2, 10000, 30000),
            'weekly_rate' => $this->faker->randomFloat(2, 50000, 200000),
            'includes_driver' => $this->faker->boolean(),
            'driver_additional_cost' => $this->faker->randomFloat(2, 2000, 8000),
            'availability_status' => $this->faker->randomElement(['available', 'rented', 'maintenance']),
            'location' => $this->faker->city(),
            'image' => $this->faker->imageUrl(),
        ];
    }
    
}
