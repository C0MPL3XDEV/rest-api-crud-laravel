<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++){
            DB::table('products')->insert([
                'name' => $faker->company . " " . $faker->numerify('Model ####'),
                'description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 10, 100),
            ]);
        }
    }
}
