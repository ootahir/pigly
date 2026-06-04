<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeightLog;
use Illuminate\Database\Seeder;

class WeightLogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('email', 'yamada@yahoo.co.jp')->first();

        if (! $user) {
            return;
        }

        $logs = require database_path('seeders/weight_logs_data.php');

        foreach ($logs as $log) {
            WeightLog::query()->create([
                'user_id' => $user->id,
                'date' => $log['date'],
                'weight' => $log['weight'],
                'calories' => $log['calories'],
                'exercise_time' => $log['exercise_time'],
                'exercise_content' => $log['exercise_content'],
            ]);
        }
    }
}
