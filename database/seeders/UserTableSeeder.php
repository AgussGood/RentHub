<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'role'     => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name'     => 'customer',
            'email'    => 'customer@gmail.com',
            'role'     => 'customer',
            'password' => Hash::make('customer'),
        ]);
    }
}
