<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'agent-list',
            'agent-create',
            'agent-edit',
            'agent-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'hotel-list',
            'hotel-create',
            'hotel-edit',
            'hotel-delete',
            'room-list',
            'room-create',
            'room-edit',
            'room-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission,'slug' => $permission]);
        }
    }
}
