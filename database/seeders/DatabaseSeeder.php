<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // User::create([
        //     'email' => 'Admin@Admin',
        //     'type' => 'Admin',
        //     'password' => Hash::make('Admin12345'),
        // ]);
        // Admin::create([
        //     'user_id' => 1,
        //     'name' => 'Admin',
        //     'national_id' => '1111',
        //     'phone' => '1111',
        //     'address' => 'gaza',
        // ]);
    }
}
