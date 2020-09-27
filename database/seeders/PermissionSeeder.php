<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                "name" => "View client dashboard",
                "slug" => "view-client-dashboard"
            ],
            [
                "name" => "View admin dashboard",
                "slug" => "view-admin-dashboard"
            ]
        ]);
    }
}
