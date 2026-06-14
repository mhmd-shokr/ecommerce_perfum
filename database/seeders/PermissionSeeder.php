<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'create product']);
        Permission::firstOrCreate(['name' => 'edit product']);
        Permission::firstOrCreate(['name' => 'delete product']);
        Permission::firstOrCreate(['name' => 'view product']);

    }
}
