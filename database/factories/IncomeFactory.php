<?php

namespace Database\Factories;

use App\Models\Income;
use App\Models\{User,Rental,Equipment};

use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition()
    {
        return [
            'owner_id'    => User::factory(),
            'rental_id'    => Rental::factory(),
            'equipment_id' => Equipment::factory(),
            'amount'       => $this->faker->randomFloat(2, 100, 5000),
            'income_date'  => $this->faker->date(),
            'description'  => $this->faker->optional()->sentence(),
        ];
    }
}