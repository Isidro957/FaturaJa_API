<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nome',
        'slug',      // adiciona o slug para multi-tenant
        'nif',
        'email',
        'endereco',
        'telefone',
        'logo',
    ];

    /**
     * Usuários associados à empresa
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
