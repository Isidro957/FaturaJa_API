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
        // Garantir que as pastas existem no storage
        Storage::disk('public')->makeDirectory('logos');
        Storage::disk('public')->makeDirectory('avatars');
        Storage::disk('public')->makeDirectory('images'); // onde estão as imagens originais

        /*
        |--------------------------------------------------------------------------
        | 1. Buscar imagens que já estão em storage/app/public/images
        |--------------------------------------------------------------------------
        */
        $logoSource = storage_path('app/public/images/f.jpg');
        $avatarSource = storage_path('app/public/images/avatar_admin.jpg');

        /*
        |--------------------------------------------------------------------------
        | 2. Salvar logo no diretório correto /logos
        |--------------------------------------------------------------------------
        */
        $logoPath = null;

        if (file_exists($logoSource)) {
            $logoPath = Storage::disk('public')->putFile(
                'logos',
                new File($logoSource)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Salvar avatar no diretório correto /avatars
        |--------------------------------------------------------------------------
        */
        $avatarPath = null;

        if (file_exists($avatarSource)) {
            $avatarPath = Storage::disk('public')->putFile(
                'avatars',
                new File($avatarSource)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Criar empresa
        |--------------------------------------------------------------------------
        */
        $empresa = Empresa::firstOrCreate(
            ['slug' => 'sistema'],
            [
                'nome' => 'Sistema',
                'nif' => '000000000',
                'email' => 'contato@sistema.com',
                'telefone' => '222222222',
                'endereco' => 'Luanda, Angola',
                'logo' => $logoPath,      // logo final no storage/logos
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 5. Criar role admin
        |--------------------------------------------------------------------------
        */
        $role = Role::firstOrCreate(['name' => 'admin']);

        /*
        |--------------------------------------------------------------------------
        | 6. Criar o usuário admin
        |--------------------------------------------------------------------------
        */
        $user = User::firstOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
                'role' => 'admin',
                'avatar' => $avatarPath,  // avatar final no storage/avatars
            ]
        );

        $user->assignRole($role);
    }
}
