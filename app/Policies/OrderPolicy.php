<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given order can be read by the user.
     *
     * @param User $user
     * @param Order $order
     *
     * @return bool
     */
    public function read(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}
