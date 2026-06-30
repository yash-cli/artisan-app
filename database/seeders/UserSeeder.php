<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $user = User::query()->create(
                [
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('Test@123'),
                ]
            );

            $user->assignRole(Role::ADMIN->value);
        });
    }
}
