<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\User;
use Spatie\Permission\Models\Role;

class EmpresaSeeder extends Seeder
{
    public function run()
    {
        // Criar role empresa se não existir
        $role = Role::firstOrCreate(['name' => 'empresa']);

        // Criar empresa de teste
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'faturaja'], 
            [
                'nome' => 'FaturaJa',
                'nif' => '123456789',
                'email' => 'contato@faturaja.com',
                'telefone' => '222222222',
                'endereco' => 'Rua Exemplo, Luanda',
                'logo' => null,
            ]
        );

        // Criar usuário admin vinculado à empresa
        $admin = User::firstOrCreate(
            ['email' => 'admin@faturaja.com'],
            [
                'name' => 'Admin FaturaJa',
                'password' => bcrypt('123456'), // senha padrão
                'empresa_id' => $empresa->id,
            ]
        );

        // Atribuir role correto ao usuário
        $admin->assignRole('empresa'); // ✅ use 'empresa' em vez de 'role'
    }
}
