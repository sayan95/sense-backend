<?php

use App\Model\Admin\Role;
use App\Model\Admin\Admin;
use App\Model\Admin\Permission;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create([
            'permission_name' => 'all_permission'
        ]);
        
        $role = Role::create([
            'role_name' => 'super_admin'
        ]);

        $role->permissions()->attach($permission->id);

        $admin = Admin::create([
            'username' => 'SuperAdmin123',
            'email' => 'superadmin@email.com',
            'password' => bcrypt('secret'),
            'role_id' => $role->id
        ]);
        
    }
}
