<?php

namespace Database\Factories;

use App\Models\WeightLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 45.0, 80.0),
            'calories' => $this->faker->numberBetween(1200, 3000),
            'exercise_time' => $this->faker->time('H:i:s'),
            'exercise_content' => $this->faker->randomElement([
                'ランニング30分',
                'ウォーキング1時間',
                '筋トレ45分',
                'ヨガ60分',
                'サイクリング40分',
                '水泳30分',
            ]),
        ];
    }
}
