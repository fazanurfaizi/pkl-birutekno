<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Faker\Factory;
use Carbon\Carbon;

class TicketsSeeder extends Seeder
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
        $projects = Project::select('id')->get();

        $status = [
            'open',
            'closed'
        ];

        for ($i = 0; $i < 10; $i++) { 
            Ticket::create([
                'user_id' => 2,
                'project_id' => $projects->random()->id,
                'subject' => $faker->sentence,
                'description' => $faker->paragraph,
                'started_at' => Carbon::now(),
                'ended_at' => Carbon::now()->addWeeks(4),
                'status' => Arr::random($status),
            ]);
        }
    }
}
