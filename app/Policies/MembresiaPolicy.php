<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Membresia;


class MembresiaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Membresia $membresia)
    {
        // Solo los administradores pueden actualizar membresías
        return $user->role === 'admin';
    }
    public function delete(User $user, Membresia $membresia)
    {
        // Solo los administradores pueden eliminar membresías
        return $user->role === 'admin';
    }
}
