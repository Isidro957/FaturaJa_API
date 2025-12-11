<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Desativar FKs
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Criar diretórios
        Storage::disk('public')->makeDirectory('logos');
        Storage::disk('public')->makeDirectory('avatars');

        /*
        |--------------------------------------------------------------------------
        | Caminhos das imagens dentro de storage/app/public/images
        |--------------------------------------------------------------------------
        */
        $adminAvatarSource  = storage_path('app/public/images/avatar_admin.jpg');
        $empresaAvatarSource = storage_path('app/public/images/avatar_empresa.jpg');
        $logoSource          = storage_path('app/public/images/f.jpg');

        // Verificar se as imagens existem
        foreach ([$adminAvatarSource, $empresaAvatarSource, $logoSource] as $file) {
            if (!file_exists($file)) {
                dd("ERRO: A imagem não existe -> " . $file);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Copiando para storage/app/public/avatars e logos
        |--------------------------------------------------------------------------
        */
        $avatarAdmin = Storage::disk('public')->putFile('avatars', new File($adminAvatarSource));
        $avatarEmpresa = Storage::disk('public')->putFile('avatars', new File($empresaAvatarSource));
        $logoPath = Storage::disk('public')->putFile('logos', new File($logoSource));

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
                'role' => 'empresa',
                'logo' => $logoPath,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Criar roles
        |--------------------------------------------------------------------------
        */
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $empresaRole = Role::firstOrCreate(['name' => 'empresa']);

        /*
        |--------------------------------------------------------------------------
        | Criar usuário admin
        |--------------------------------------------------------------------------
        */
        $admin = User::firstOrCreate(
            ['email' => 'admin@faturaja.com'], 
            [
                'name' => 'Admin FaturaJa',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
                'role' => 'admin',
                'avatar' => $avatarAdmin,
            ]
        );
        $admin->assignRole($adminRole);

        /*
        |--------------------------------------------------------------------------
        | Criar usuário normal da empresa
        |--------------------------------------------------------------------------
        */
        $usuarioEmpresa = User::firstOrCreate(
            ['email' => 'fatimaempresa@faturaja.com'], 
            [
                'name' => 'Fatima Empresa',
                'password' => bcrypt('123456'),
                'empresa_id' => $empresa->id,
                'role' => 'empresa',
                'avatar' => $avatarEmpresa,
            ]
        );
        $usuarioEmpresa->assignRole($empresaRole);

        // Ativar FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
