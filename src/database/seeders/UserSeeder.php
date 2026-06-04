<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeightTarget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => '山田　太郎',
            'email' => 'yamada@yahoo.co.jp',
            'password' => Hash::make('yamada2026'),
        ]);

        WeightTarget::factory()->create([
            'user_id' => $user->id,
        ]);
    }
}
