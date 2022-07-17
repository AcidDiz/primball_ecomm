<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // foreach ($this->roles() as $role) {
        //     Role::create(['name' => $role]);
        // }


        $super_admin = Role::where('name', 'SuperAdmin')->get();
        // $admin = Role::where('name', 'Admin')->get();
        // $team_leader = Role::where('name', 'Team Leader')->get();
        // $team_manager = Role::where('name', 'Team Manager')->get();
        // $team_member = Role::where('name', 'Team Member')->get();
        // $user = Role::where('name', 'User')->get();

        User::find(1)->assignRole($super_admin);

        Permission::create(['name' => 'view permissions module']);
        Permission::create(['name' => 'view permissions list']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'view roles module']);
        Permission::create(['name' => 'view roles list']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'view users module']);
        Permission::create(['name' => 'view user list']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view categories module']);
        Permission::create(['name' => 'view category list']);
        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);

        Permission::create(['name' => 'view products module']);
        Permission::create(['name' => 'view product list']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);
    }

    private function roles(): array
    {

        return [
            'SuperAdmin',
            'Admin',
            'Team Leader',
            'Team Manager',
            'Team Member',
            'User',
        ];
    }
}
