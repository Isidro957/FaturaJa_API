<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Cliente;
use App\Models\Empresa;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Cria role cliente, caso não exista
        $role = Role::firstOrCreate(['name' => 'cliente']);

        // Pega todas as empresas para gerar clientes
        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {
            // Cria clientes
            $cliente1 = Cliente::create([
                'empresa_id' => $empresa->id,
                'nome' => 'Cliente Padrão ' . $empresa->nome,
                'email' => 'cliente.' . $empresa->id . '@gmail.com',
                'telefone' => '92300000' . rand(1,9),
                'endereco' => 'Luanda, Angola',
            ]);

            $cliente2 = Cliente::create([
                'empresa_id' => $empresa->id,
                'nome' => 'Cliente Secundário ' . $empresa->nome,
                'email' => 'cliente2.' . $empresa->id . '@gmail.com',
                'telefone' => '92311111' . rand(1,9),
                'endereco' => 'Cazenga, Luanda',
            ]);

            // Se o modelo Cliente usar HasRoles, você pode atribuir role assim:
            // $cliente1->assignRole($role);
            // $cliente2->assignRole($role);
        }
    }
}
