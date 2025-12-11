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
        // Criar pastas caso não existam
        Storage::disk('public')->makeDirectory('logos');
        Storage::disk('public')->makeDirectory('avatars');

        /*
        |--------------------------------------------------------------------------
        | Avatar do Admin - vindo de storage/app/public/images
        |--------------------------------------------------------------------------
        */
        $avatarSource = storage_path('app/public/images/avatar_admin.jpg');

        if (!file_exists($avatarSource)) {
            dd("ERRO: A imagem do avatar não existe em: " . $avatarSource);
        }

        $avatarAdmin = Storage::disk('public')->putFile(
            'avatars',
            new File($avatarSource)
        );

        /*
        |--------------------------------------------------------------------------
        | Logo da Empresa - vindo de storage/app/public/images
        |--------------------------------------------------------------------------
        */
        $logoSource = storage_path('app/public/images/f.jpg');

        if (!file_exists($logoSource)) {
            dd("ERRO: A logo não existe em: " . $logoSource);
        }

        $logoPath = Storage::disk('public')->putFile(
            'logos',
            new File($logoSource)
        );

        /*
        |--------------------------------------------------------------------------
        | Criar Empresa
        |--------------------------------------------------------------------------
        */
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'faturaja'],
            [
                'nome' => 'FaturaJa',
                'nif' => '123456789',
                'email' => 'contato@faturaja.com',
                'telefone' => '222222222',
                'endereco' => 'Rua Exemplo, Luanda',
                'logo' => $logoPath, // caminho final
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Criar Usuário Admin
        |--------------------------------------------------------------------------
        */
        User::firstOrCreate(
            ['email' => 'admin@faturaja.com'],
            [
                'name' => 'Admin FaturaJa',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
                'role' => 'admin',
                'avatar' => $avatarAdmin, // caminho final
            ]
        );
    }
}
