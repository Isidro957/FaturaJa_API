<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Desativa FK temporariamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Buscar a empresa que já existe
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'faturaja'], // se não existir, cria
            [
                'nome' => 'FaturaJa',
                'nif' => '123456789',
                'email' => 'contato@faturaja.com',
                'telefone' => '222222222',
                'endereco' => 'Rua Exemplo, Luanda',
                'logo' => null,
            ]
        );

        // Criar usuário admin
        User::firstOrCreate(
            ['email' => 'admin@faturaja.com'], // evita duplicação
            [
                'name' => 'Admin FaturaJa',
                'password' => bcrypt('123456'), // senha padrão
                'empresa_id' => $empresa->id,
            ]
        );

        // Reativa FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


    }
