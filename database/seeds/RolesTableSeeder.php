<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $defaultRole = new Role();
        $defaultRole->name = "Default";
        $defaultRole->save();

        $adminRole = new Role();
        $adminRole->name = "Admin";
        $adminRole->save();

        $permissionManagement = new Permission();
        $permissionManagement->name = "RoleController";
        $permissionManagement->label = "Quản lý quyền";
        $permissionManagement->save();
       
        $listPermission = new Permission();
        $listPermission->name = "RoleController.index";
        $listPermission->label = "Xem danh sách";
        $listPermission->parent_id = $permissionManagement->id;
        $listPermission->save();

        $syncPermission = new Permission();
        $syncPermission->name = "RoleController.synchronousPermissions";
        $syncPermission->label = "Đồng bộ quyền";
        $syncPermission->parent_id = $permissionManagement->id;
        $syncPermission->save();

        $adminRole->assignPermission($listPermission);
        $adminRole->assignPermission($syncPermission);

        $firstUser = User::first();
        $firstUser->assignRole($defaultRole);
        $firstUser->assignRole($adminRole);
    }
}
