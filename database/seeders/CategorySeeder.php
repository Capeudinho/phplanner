<?php

namespace Database\Seeders;

use App\Enums\CategoryColor;
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
            'color' => CategoryColor::RED,
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Esporte',
            'color' => CategoryColor::BLUE,
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Estudo',
            'color' => CategoryColor::GREEN,
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Trabalho',
            'color' => CategoryColor::YELLOW,
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Lazer',
            'color' => CategoryColor::PURPLE,
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Reuniões',
            'color' => CategoryColor::ORANGE,
            'user_id' => 1,
        ]);

        DB::table('categories')->insert([
            'name' => 'Outros',
            'color' => CategoryColor::GRAY,
            'user_id' => 1,
        ]);
    }
}