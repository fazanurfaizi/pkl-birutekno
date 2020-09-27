<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                "name" => "Client",
                "slug" => "client"
            ],
            [
                "name" => "Admin",
                "slug" => "admin"
            ],
        ]);

        $clientRole = Role::client()->firstOrFail();
        $clientPermissions = Permission::whereIn('slug', ['view-client-dashboard'])->get()->pluck('id')->toArray();
        $clientRole->permissions()->sync($clientPermissions);
    }
}
