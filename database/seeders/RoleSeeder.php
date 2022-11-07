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
        $role1 = Role::create(['name'=>'ADMIN']);
        $role2 = Role::create(['name'=>'RRHH']);
        $role3 = Role::create(['name'=>'COLABORADOR']);

        Permission::create(['name'=>'novedades.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'novedades.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'novedades.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'novedades.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'recibos.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'recibos.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'recibos.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'recibos.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'documentacion.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'documentacion.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'documentacion.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'documentacion.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'licencias.index'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'licencias.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'licencias.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'licencias.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'rrhh.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'rrhh.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'rrhh.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'rrhh.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'administracion.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'administracion.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'administracion.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'administracion.destroy'])->syncRoles([$role1]);
    }
}
