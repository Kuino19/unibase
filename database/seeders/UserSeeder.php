<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $studentRole = Role::where('name', 'Student')->first();
        if ($studentRole) {
            User::factory()->count(5)->create([
                'role_id' => $studentRole->id,
            ]);
        }
    }
}
