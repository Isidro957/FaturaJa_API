<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Empresa;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Pega todas as empresas para gerar clientes em cada uma
        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {
            
            Cliente::create([
                'empresa_id' => $empresa->id,
                'nome' => 'Cliente Padrão ' . $empresa->nome,
                'email' => 'cliente.' . $empresa->id . '@gmail.com',
                'telefone' => '92300000' . rand(1,9),
                'endereco' => 'Luanda, Angola',
            ]);

            Cliente::create([
                'empresa_id' => $empresa->id,
                'nome' => 'Cliente Secundário ' . $empresa->nome,
                'email' => 'cliente2.' . $empresa->id . '@gmail.com',
                'telefone' => '92311111' . rand(1,9),
                'endereco' => 'Cazenga, Luanda',
            ]);
        }
    }
}
