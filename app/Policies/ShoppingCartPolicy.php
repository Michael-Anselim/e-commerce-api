<?php

namespace App\Policies;

use App\Models\ShoppingCart;
use App\Models\User;

class ShoppingCartPolicy
{
    public function view(User $user, ShoppingCart $shoppingCart): bool
    {
        return $shoppingCart->user_id === $user->id;
    }

    public function update(User $user, ShoppingCart $shoppingCart): bool
    {
        return $shoppingCart->user_id === $user->id;
    }

    public function delete(User $user, ShoppingCart $shoppingCart): bool
    {
        return $shoppingCart->user_id === $user->id;
    }

    public function removeProduct(User $user, ShoppingCart $shoppingCart): bool
    {
        return $shoppingCart->user_id === $user->id;
    }
}
