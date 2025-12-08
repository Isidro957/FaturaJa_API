<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\User;

class EmpresaSeeder extends Seeder
{
    public function run()
    {
        // Criar uma empresa de teste
        $empresa = Empresa::create([
            'nome' => 'FaturaJa',
            'slug' => 'faturaja',
            'nif' => '123456789',
            'email' => 'contato@faturaja.com',
            'telefone' => '222222222',
            'endereco' => 'Rua Exemplo, Luanda',
            'logo' => null,
        ]);

        // Criar um usuário admin vinculado à empresa
        User::create([
            'name' => 'Admin FaturaJa',
            'email' => 'admin@faturaja.com',
            'password' => bcrypt('123456'), // senha padrão
            'empresa_id' => $empresa->id,
        ]);
    }
}
