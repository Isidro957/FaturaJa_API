<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Empresa;
use App\Models\User;

class EmpresaSeeder extends Seeder
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

        // Criar empresa de teste com a logo
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'faturaja'],
            [
                'nome' => 'FaturaJa',
                'nif' => '123456789',
                'email' => 'contato@faturaja.com',
                'telefone' => '222222222',
                'endereco' => 'Rua Exemplo, Luanda',
                'logo' => $logoPath,   // <-- caminho final já salvo
                
            ]
        );

        // Criar usuário admin
        User::firstOrCreate(
            ['email' => 'admin@faturaja.com'],
            [
                'name' => 'Admin FaturaJa',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
                'role' => 'admin',
            ]
        );
    }
}
