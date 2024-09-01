<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        DB::table('categories')->insert([
            'name' => 'Saúde',
            'color' => 'red',
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Esporte',
            'color' => 'blue',
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Estudo',
            'color' => 'green',
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Trabalho',
            'color' => 'yellow',
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Lazer',
            'color' => 'purple',
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Reuniões',
            'color' => 'orange',
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Outros',
            'color' => 'gray',
            'user_id' => 1,
        ]);
    }
}