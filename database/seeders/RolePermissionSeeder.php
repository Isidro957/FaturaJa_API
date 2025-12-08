<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // RESETAR CACHE
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // PERMISSÕES DO SISTEMA
        Permission::create(['name' => 'gerenciar usuarios']);
        Permission::create(['name' => 'gerenciar empresas']);
        Permission::create(['name' => 'gerenciar faturas']);
        Permission::create(['name' => 'gerenciar clientes']);
        Permission::create(['name' => 'ver relatorios']);
        Permission::create(['name' => 'receber faturas']);

        // ROLES
        $admin = Role::create(['name' => 'admin']);
        $empresa = Role::create(['name' => 'empresa']);
        $clienteFinal = Role::create(['name' => 'cliente']);

        // PERMISSÕES DO ADMIN
        $admin->givePermissionTo([
            'gerenciar usuarios',
            'gerenciar empresas',
            'gerenciar faturas',
            'gerenciar clientes',
            'ver relatorios',
        ]);

        // PERMISSÕES DA EMPRESA
        $empresa->givePermissionTo([
            'gerenciar faturas',
            'gerenciar clientes',
            'ver relatorios',
        ]);

        // PERMISSÕES DO CLIENTE FINAL
        $clienteFinal->givePermissionTo([
            'receber faturas',
        ]);
    }
}
