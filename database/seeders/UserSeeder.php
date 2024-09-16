<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run(): void {
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=>Hash::make('password'),
            'email_verified_at'=>'2024-01-01',
			'remember_token' => Str::random(10),
        ]);
    }
}