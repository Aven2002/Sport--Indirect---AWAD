<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the given order can be updated by the user (admin or owner).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order $order
     * @return bool
     */
    public function updateStatus(User $user, Order $order)
    {
 
        // Compare user id and order user id or check if user has 'Admin' role
        if ($user->id === $order->user_id) {
            return response()->json(['message' => 'Update allowed'], 200);
        }
    
        // If none of the conditions are met, return a forbidden response
        return response()->json(['message' => 'This action is unauthorized.'], 403);
    }
    

}
