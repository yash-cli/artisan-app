<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Enums\Role as RoleEnum;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roleArr = array_map(fn($role) => [
            'name' => $role->value,
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ], RoleEnum::cases());

        Role::insert($roleArr);
    }
}
