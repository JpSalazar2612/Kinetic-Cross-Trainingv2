<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;

class VentaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
   public function update(User $user, Venta $venta)
    {
        return $user->role === 'admin';
    }
    public function delete(User $user, Venta $venta)
    {
        return $user->role === 'admin';
    
    }
}
