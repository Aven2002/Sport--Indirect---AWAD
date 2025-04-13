<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
   
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
        try{
            $validatedData = $request->validate([
                'user_id'=> 'required|integer'
            ]);

            $cart = Cart::firstOrCreate($validatedData);

            return response()->json([
                'message'=>'Cart created successfully',
                'cart'=>$cart
            ],201);

        }catch(ValidationException $e)
        {
            return reponse()->json([
                'message'=>'Validation error',
                'errors'=>$e->errors()
            ],422);

        }catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

}
