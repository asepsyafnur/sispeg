<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorities = config('permission.authorities');
        
        $listPermission = [];
        $adminPermission = [];
        $pegawaiPermission = [];

        foreach ($authorities as $label => $permissions) {
            foreach ($permissions as $permission) {
                $listPermission[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $adminPermission[] = $permission;

                // pegawai
                if(in_array($label, ['manage_absensi', 'manage_users'])){
                    $pegawaiPermission[] = $permission;
                }
            }
        }

        Permission::insert($listPermission);

        $admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $pegawai = Role::create([
            'name' => 'Pegawai',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $admin->givePermissionTo($adminPermission);
        $pegawai->givePermissionTo($pegawaiPermission);



        $userAdmin = User::find(1)->assignRole('admin');
    }
}
