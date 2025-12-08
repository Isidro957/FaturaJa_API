<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\EmpresaSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ClienteSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(EmpresaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(ClienteSeeder::class);  

        // Desativa FK temporariamente para evitar erros
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');




        // Opcional: criar um usuário de teste extra
        \App\Models\User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
            'empresa_id' => \App\Models\Empresa::first()->id,
        ]);

        // Reativa FK
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
