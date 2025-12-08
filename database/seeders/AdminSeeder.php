<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buscar uma empresa existente ou criar uma genérica
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'sistema'],
            [
                'nome' => 'Sistema',
                'nif' => '000000000',
                'email' => 'contato@sistema.com',
                'telefone' => '222222222',
                'endereco' => 'Luanda, Angola',
                'logo' => null,
            ]
        );

        // Cria a role admin se não existir
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Cria o usuário admin se não existir
        $user = User::firstOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('123456'), // Senha padrão
                'empresa_id' => $empresa->id,    // ⚠ Necessário se empresa_id for obrigatório
            ]
        );

        // Atribui a role admin ao usuário
        $user->assignRole($role);
    }
}
