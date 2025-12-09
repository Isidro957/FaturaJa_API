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
    $permissions = [
        'gerenciar usuarios' => ['admin', 'empresa'],
        'gerenciar empresas' => ['admin'],
        'gerenciar faturas' => ['admin', 'empresa'],
        'gerenciar clientes' => ['admin', 'empresa'],
        'ver relatorios' => ['admin', 'empresa'],
        'receber faturas' => ['cliente'],
    ];

    // Criar roles
    $roles = [];
    foreach (['admin', 'empresa', 'cliente'] as $roleName) {
        $roles[$roleName] = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
    }

    // Criar permissões e atribuir às roles correspondentes
    foreach ($permissions as $permName => $roleNames) {
        $permission = Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        foreach ($roleNames as $roleName) {
            $roles[$roleName]->givePermissionTo($permission);
        }
    }
}

}
