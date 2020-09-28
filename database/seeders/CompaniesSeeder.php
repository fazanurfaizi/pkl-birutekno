<?php

namespace Database\Seeders;

use App\Models\Company;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) { 
            Company::create([
                'name' => $faker->company,
                'logo' => $faker->imageUrl($width = 640, $height = 480),
                'description' => $faker->paragraph
            ]);
        }
    }
}
