<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Desativa FK temporariamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Buscar ou criar empresa FaturaJa
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

        // Criar roles caso não existam
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $empresaRole = Role::firstOrCreate(['name' => 'empresa']);

        // Criar usuário admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@faturaja.com'], 
            [
                'name' => 'Admin FaturaJa',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
            ]
        );
        $admin->assignRole($adminRole);

        // Criar usuário padrão da empresa
        $usuarioEmpresa = User::firstOrCreate(
            ['email' => 'empresa@faturaja.com'], 
            [
                'name' => 'Usuário Empresa',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
            ]
        );
        $usuarioEmpresa->assignRole($empresaRole);

        // Reativa FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
