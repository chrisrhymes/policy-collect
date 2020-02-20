<?php

namespace ChrisRhymes\PolicyCollect\Tests\Policies;

use ChrisRhymes\PolicyCollect\Tests\Models\User;
use ChrisRhymes\PolicyCollect\Tests\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any orders.
     *
     * @param User $user
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the order.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order)
    {
        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  User  $user
     * @param  Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  User  $user
     * @param  Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can restore the order.
     *
     * @param  User  $user
     * @param  Order  $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the order.
     *
     * @param  User  $user
     * @param  Order  $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        return false;
    }

    public function customMethod(User $user, Order $order)
    {
        return true;
    }
}
