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
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Abdullah',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => config('global.role.ROLE_ADMIN')
        ]);
        User::create([
            'name' => 'User-1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user123'),
            'role' => config('global.role.ROLE_USER')
        ]);
        User::create([
            'name' => 'User-2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user123'),
            'role' => config('global.role.ROLE_USER')
        ]);
        User::create([
            'name' => 'User-3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('user123'),
            'role' => config('global.role.ROLE_USER')
        ]);
    }
}
