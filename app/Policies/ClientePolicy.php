<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cliente;

class ClientePolicy
{
    /**
     * Ver lista de clientes
     */public function viewAny(User $user)
{
    return $user->hasRole(['admin', 'empresa']);
}

public function create(User $user)
{
    return $user->hasRole(['admin', 'empresa']);
}

public function update(User $user, Cliente $cliente)
{
    return $user->hasRole(['admin', 'empresa'])
        && $cliente->empresa_id === $user->empresa_id;
}

public function delete(User $user, Cliente $cliente)
{
    return $user->hasRole('admin')
        && $cliente->empresa_id === $user->empresa_id;
}

}
