<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cliente;

class ClientePolicy
{
    /**
     * Ver lista de clientes
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'empresa']);
    }

    /**
     * Criar cliente
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'empresa']);
    }

    /**
     * Editar cliente
     */
    public function update(User $user, Cliente $cliente)
    {
        // Só pode editar clientes da sua própria empresa
        return $user->empresa_id === $cliente->empresa_id
            && $user->hasAnyRole(['admin', 'empresa']);
    }

    /**
     * Apagar cliente — Somente administrador
     */
    public function delete(User $user, Cliente $cliente)
    {
        return $user->hasRole('admin')
            && $user->empresa_id === $cliente->empresa_id;
    }
}
