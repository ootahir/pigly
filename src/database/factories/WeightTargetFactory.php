<?php

namespace Database\Factories;

use App\Models\WeightTarget;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightTargetFactory extends Factory
{
    protected $model = WeightTarget::class;

    public function definition(): array
    {
        return [
            'target_weight' => $this->faker->randomFloat(1, 45.0, 75.0),
        ];
    }
}
