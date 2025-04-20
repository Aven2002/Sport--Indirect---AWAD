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
        $user = auth()->user();
        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
                'user' => null,  // Return null for the user if not found
            ], 403);
        }
    
        // Check if order exists
        if (!$order) {
            return response()->json([
                'message' => 'Order not found.',
                'order' => null,  // Return null for the order if not found
            ], 404);
        }
    
        // Debug: Return the values you're comparing
        return response()->json([
            'user_id' => $user->id,
            'order_user_id' => $order->user_id,
            'user_role' => $user->userRole,
            'comparison_result' => ($user->id === $order->user_id || $user->userRole === 'Admin'),
        ], 200);
    
        // Compare user id and order user id or check if user has 'Admin' role
        if ($user->id === $order->user_id || $user->userRole === 'Admin') {
            return response()->json(['message' => 'Update allowed'], 200);
        }
    
        // If none of the conditions are met, return a forbidden response
        return response()->json(['message' => 'This action is unauthorized.'], 403);
    }
    

}
