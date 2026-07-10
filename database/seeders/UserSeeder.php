<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=User::firstOrCreate(
            ["email"=>'mohamed212shokr@gmail.com'],
            [
                "name"=>'Admin',
                "password"=>Hash::make('password'),
                'is_active'=>true,
            ]
        );

        $admin->assignRole('admin');

        $customer=User::firstOrCreate(
            ["email"=>'customer@customer.com'],
            [
                "name"=>'customer',
                "password"=>Hash::make('password'),
                'is_active'=>true,
            ]
        );

        $customer->assignRole('Customer');
    }
}
