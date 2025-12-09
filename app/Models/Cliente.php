<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Cliente extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'clientes';
    protected $guard_name = 'web';

    protected $fillable = [
        'empresa_id',
        'nome',
        'email',
        'telefone',
        'endereco',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
