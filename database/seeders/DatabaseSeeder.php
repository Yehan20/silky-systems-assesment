<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call([
        //     RoleSeeder::class
        // ]);

        // Team::create([
        //     'name'=>'Team A'
        // ]);
        // Team::create([
        //     'name'=>'Team B'
        // ]);
        // Team::create([
        //     'name'=>'Team C'
        // ]);

        User::create([
            'name'=>'jane',
            'email'=>'jane@test.com',
            'role_id'=>Role::IS_MEMBER,
            'password'=>Hash::make('password'),
        ]);

        User::create([
            'name'=>'mario',
            'email'=>'mario@test.com',
            'role_id'=>Role::IS_MEMBER,
            'password'=>Hash::make('password'),
        ]);

        User::create([
            'name'=>'luigi',
            'email'=>'luigi@test.com',
            'role_id'=>Role::IS_MEMBER,
            'password'=>Hash::make('password'),
        ]);

        User::create([
            'name'=>'alissa',
            'email'=>'alissa@test.com',
            'role_id'=>Role::IS_MEMBER,
            'password'=>Hash::make('password'),
        ]);
    }
}
