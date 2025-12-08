<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Empresa;

class EmpresaPolicy
{
    // Apenas admin vê lista
    public function viewAny(User $user)
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Empresa $empresa)
    {
        return $user->hasRole('admin');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Empresa $empresa)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Empresa $empresa)
    {
        return $user->hasRole('admin');
    }
}
