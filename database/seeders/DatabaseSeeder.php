<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EquipmentCategory;
use App\Models\Equipment;
use App\Models\Driver;
use App\Models\Rental;
use App\Models\Income;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed categories
        $categories = EquipmentCategory::factory()->count(5)->create();

        // Seed renters with related equipments, drivers, and nested rentals/incomes
        User::factory()
            ->count(5)
            ->renter()
            ->has(
                Equipment::factory()
                    ->count(3)
                    ->state(function (array $attributes) use ($categories) {
                        return [
                            'category_id' => $categories->random()->id,
                        ];
                    })
                    // Each equipment has rentals, and each rental has an income record
                    ->has(
                        Rental::factory()
                            ->count(2)
                            ->state(function (array $attributes, Equipment $equipment) {
                                return [
                                    'equipment_id' => $equipment->id,
                                    'owner_id' => $equipment->owner_id,
                                ];
                            })
                            ->has(
                                Income::factory()
                                    ->count(1)
                                    ->state(function (array $attributes, Rental $rental) {
                                        return [
                                            'owner_id' => $rental->owner_id,
                                            'rental_id' => $rental->id,
                                            'equipment_id' => $rental->equipment_id,
                                        ];
                                    }),
                                'incomes'
                            ),
                        'rentals'
                    ),
                'equipment'
            )
            ->has(
                Driver::factory()->count(2),
                'drivers'
            )
            ->create();

        // Seed farmers (without equipment)
        User::factory()
            ->count(10)
            ->farmer()
            ->create();
    }
}