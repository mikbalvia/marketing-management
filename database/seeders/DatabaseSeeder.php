<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('users')->insert(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'role'  => 'admin'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'agent 1',
                'email' => 'agent1@gmail.com',
                'password' => bcrypt('agent'),
                'role'  => 'agent'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'agent 2',
                'email' => 'agent2@gmail.com',
                'password' => bcrypt('agent'),
                'role'  => 'agent'
            ]
        );
        DB::table('statuses')->insert(
            [
                'name' => 'uncontacted'
            ]
        );
        DB::table('statuses')->insert(
            [
                'name' => 'pending'
            ]
        );
        DB::table('statuses')->insert(
            [
                'name' => 'qualified'
            ]
        );
        DB::table('statuses')->insert(
            [
                'name' => 'lost'
            ]
        );

    }
}
