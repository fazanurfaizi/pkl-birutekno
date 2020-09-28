<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {                
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(CompaniesSeeder::class);        
        $this->call(CategoriesSeeder::class);
        $this->call(PrioritiesSeeder::class);

        $companies = Company::select('id')->get();

        $admin = User::create([
            'fullname' => 'admin birutekno',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'company_id' => $companies->random()->id
        ]);
        
        $client = User::create([
            'fullname' => 'client birutekno',
            'username' => 'client',
            'email' => 'client@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'client',
            'company_id' => $companies->random()->id
        ]);

        $employee = User::create([
            'fullname' => 'employee birutekno',
            'username' => 'employee',
            'email' => 'employee@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'employee',
            'company_id' => $companies->random()->id
        ]);

        $this->call(ProjectsSeeder::class);
        $this->call(TicketsSeeder::class);                
    }
}
