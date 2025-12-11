<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Empresa;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(EmpresaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(AdminSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
        |--------------------------------------------------------------------------
        | Copiar avatar do cliente (já existente na pasta storage/images)
        |--------------------------------------------------------------------------
        */

        $source = storage_path('app/public/images/avatar_cliente.jpg');

        if (!file_exists($source)) {
            dd("ERRO: O avatar do cliente não existe em: " . $source);
        }

        // Copia a imagem real para storage/app/public/avatars
        $avatarCliente = Storage::disk('public')->putFile(
            'avatars',
            new File($source)
        );

        /*
        |--------------------------------------------------------------------------
        | Criar usuário de teste
        |--------------------------------------------------------------------------
        */

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
            'empresa_id' => Empresa::first()->id,
            'role' => 'cliente',
            'avatar' => $avatarCliente,  // <-- caminho real correto
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
