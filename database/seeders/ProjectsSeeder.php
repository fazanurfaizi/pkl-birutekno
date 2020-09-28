<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Faker\Factory;
use Carbon\Carbon;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $users = User::select('id')->get();
        $categories = Category::select('id')->get();    

        $projects = [
            'vros',
            'stfi',
            'cashless'
        ];

        $status = [
            'open',
            'closed'
        ];

        foreach ($projects as $project) {
            Project::create([
                'user_id' => '2',
                'category_id' => $categories->random()->id,
                'name' => $project,
                'estimated_budget' => rand(500, 20000),
                'description' => $faker->paragraph(5),
                'status' => Arr::random($status),
                'started_at' => Carbon::now(),
                'ended_at' => Carbon::now()->addWeeks(4)
            ]);
        }
    }
}
