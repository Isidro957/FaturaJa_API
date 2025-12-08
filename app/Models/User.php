<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <- IMPORTANTE
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; // <- ADICIONE HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'empresa_id',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relação com empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
