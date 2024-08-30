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
        ]);

        DB::table('categories')->insert([
            'name' => 'Esporte',
            'color' => 'blue',
        ]);

        DB::table('categories')->insert([
            'name' => 'Estudo',
            'color' => 'green',
        ]);

        DB::table('categories')->insert([
            'name' => 'Trabalho',
            'color' => 'yellow',
        ]);

        DB::table('categories')->insert([
            'name' => 'Lazer',
            'color' => 'purple',
        ]);

        DB::table('categories')->insert([
            'name' => 'Reuniões',
            'color' => 'orange',
        ]);

        DB::table('categories')->insert([
            'name' => 'Outros',
            'color' => 'gray',
        ]);
    }
}