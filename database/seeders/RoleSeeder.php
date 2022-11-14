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
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=>'admin']);
        $role2 = Role::create(['name'=>'rrhh']);
        $role3 = Role::create(['name'=>'colaborator']);

        Permission::create(['name'=>'news.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'news.show'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'news.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'news.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'news.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'paychecks.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'paychecks.show'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'paychecks.create'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name'=>'files.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'files.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'files.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'files.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'documents.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'documents.create'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'documents.edit'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'documents.destroy'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name'=>'rrhh.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'rrhh.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'rrhh.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'rrhh.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'roles.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'roles.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'roles.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'roles.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'administration.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'administration.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'administration.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'administration.destroy'])->syncRoles([$role1]);

        Permission::create(['name'=>'activity.index'])->syncRoles([$role1, $role2]);

    }
}
