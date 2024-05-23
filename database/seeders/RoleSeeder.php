<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleadministrador = Role::create(['name' => 'administrador']);
        $roleoperador = Role::create(['name' => 'operador']);
        $roleauditor = Role::create(['name' => 'auditor']);

        $permissionview = Permission::create(['name' => 'view']);
        $permissionedit = Permission::create(['name' => 'edit']);
        $permissiondelete = Permission::create(['name' => 'delete']);
        $permissioncreate = Permission::create(['name' => 'create']);
        $permissionbankaccount = Permission::create(['name' => 'bankaccount']);
        $permissionmgmtusers = Permission::create(['name' => 'mgmtusers']);



        $roleadministrador->syncPermissions([$permissionview, $permissionedit, $permissiondelete, $permissioncreate, $permissionbankaccount, $permissionmgmtusers]);
        $roleoperador->syncPermissions([$permissionview, $permissioncreate]);
        $roleauditor->syncPermissions([$permissionview, $permissionbankaccount]);




    }
}
