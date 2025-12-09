<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;   

class AdminSeeder extends Seeder
{
    public function run()
    {

         // Verifica e cria pasta storage/app/public/logos
        Storage::disk('public')->makeDirectory('logos');

        // Copiar imagem da pasta public/images para storage
        $logoPath = 'images/f.jpg';
        $sourcePath = public_path('images/f.jpg');

        if (file_exists($sourcePath)) {
            $logoPath = Storage::disk('public')->putFile('images', new File($sourcePath));
        }
        // Buscar uma empresa existente ou criar uma genérica
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'sistema'],
            [
                'nome' => 'Sistema',
                'nif' => '000000000',
                'email' => 'contato@sistema.com',
                'telefone' => '222222222',
                'endereco' => 'Luanda, Angola',
                'logo' => $logoPath,
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
                'empresa_id' => $empresa->id, 
                'role' => 'admin',
            ]
        );

        // Atribui a role admin ao usuário
        $user->assignRole($role);
    }

}
