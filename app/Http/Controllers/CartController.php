<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
   /**
    * Retrieve all cart 
    */
    public function index()
    {
        try{

            $carts = Cart::all();

            if($carts->isEmpty())
            {
                return response()->json([
                    'message'=>'The table is empty'
                ],404);
            }

            return response()->json([
                'message'=>'All cart records retrieved successfully',
                'carts'=>$carts
            ],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
    * Retrieve specific user cartID
    */
    public function getUserCartId($id)
    {
        try {
            $cart = Cart::where('user_id', $id)->first();

            if (!$cart) {
                return response()->json([
                    'message' => "User's cart ID not found"
                ], 200);
            }

            return response()->json([
                'message' => "User's cart ID retrieved successfully",
                'cartId' => $cart->id
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retrieve specific cart with details by id
     */
    public function show($id)
    {
        try{
            $cart = Cart::with('cartDetail')->find($id);

            if(!$cart)
            {
                return response()->json([
                    'message'=>'Cart not found'
                ],404);
            }

            return response()->json([
                'message'=>'Cart record retrieved successfully',
                'cart'=>$cart
            ],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specific cart
     */
    public function destroy($id)
    {
        try{
            $cart = Cart::find($id);

            if(!$cart)
            {
                return response()->json([
                    'message'=>'Cart record not found'
                ],404);
            }

            $cart->delete();
            return response()->json([
                'message'=>'Cart deleted successfully'
            ],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Store a newly created cart
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer'
            ]);

            // This prevents duplicate carts for the same user
            $cart = Cart::firstOrCreate(['user_id' => $validatedData['user_id']]);

            return response()->json([
                'message' => 'Cart created successfully',
                'cart' => $cart
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
