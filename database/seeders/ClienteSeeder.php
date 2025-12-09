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
        $role = Role::firstOrCreate(['name' => 'cliente']);

        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {

            $cliente1 = Cliente::create([
                'empresa_id' => $empresa->id,
                'nome' => 'Diniz Cabenda ' . $empresa->nome,
                'email' => 'diniz123.' . $empresa->id . '@gmail.com',
                'telefone' => '92300000' . rand(1,9),
                'endereco' => 'Luanda, Angola',
            ]);

            $cliente2 = Cliente::create([
                'empresa_id' => $empresa->id,
                'nome' => 'Vanio Almeida ' . $empresa->nome,
                'email' => 'vanio123.' . $empresa->id . '@gmail.com',
                'telefone' => '92311111' . rand(1,9),
                'endereco' => 'Cazenga, Luanda',
            ]);

            $cliente1->assignRole($role);
            $cliente2->assignRole($role);
        }
    }
}
