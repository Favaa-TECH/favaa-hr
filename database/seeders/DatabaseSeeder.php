<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        \App\Models\User::factory(10)->create();
//
//         \App\Models\User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'admin@example.com',
//             'role' => 'Administrator',
//             'password' => bcrypt('password123'),
//             'email_verified_at' => null,
//             'created_at' => null,
//             'remember_token' => null,
//         ]);
//         \App\Models\User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'employee@example.com',
//             'role' => 'Employee',
//             'password' => bcrypt('password123'),
//             'email_verified_at' => null,
//             'created_at' => null,
//             'remember_token' => null,
//         ]);


//        DB::table('users')->insert([
//            [
//                'name' => 'John Doe',
//                'email' => 'admin@example.com',
//                'role' => 'Administrator',
//                'password' => Hash::make('password'),
//            ],
//            [
//                'name' => 'Jane Smith',
//                'email' => 'empl@example.com',
//                'role' => 'Employee',
//                'password' => Hash::make('password'),
//            ],
//        ]);

        $this->call([
            UserSeeder::class,
        ]);
    }
}
