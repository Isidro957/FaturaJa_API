<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Desativa FK temporariamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Copiar a imagem para o storage (logo da empresa)
        $logoPath = Storage::putFile(
            'logos',
            new \Illuminate\Http\File(public_path('images/f.jpg'))
        );

        // Buscar ou criar empresa FaturaJa
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'faturaja'], 
            [
                'nome' => 'FaturaJa',
                'nif' => '123456789',
                'email' => 'contato@faturaja.com',
                'telefone' => '222222222',
                'endereco' => 'Rua Exemplo, Luanda',
                'role' => 'empresa',
                'logo' => $logoPath, // caminho salvo no storage
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
                'role' => 'admin',
            ]
        );
        $admin->assignRole($adminRole);

        // Criar usuário padrão da empresa
        $usuarioEmpresa = User::firstOrCreate(
            ['email' => 'fatimaempresa@faturaja.com'], 
            [
                'name' => 'Fatima Empresa',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
                'role' => 'empresa',
            ]
        );
        $usuarioEmpresa->assignRole($empresaRole);

        // Reativa FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
