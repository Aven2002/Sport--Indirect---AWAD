<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\CartDetail;

class CartDetailController extends Controller
{
    /**
     * Retrieve all cart details info
     */
    public function index()
    {
        try{
            $cartDetails = CartDetail::all();

            if($cartDetails->isEmpty())
            {
                return response()->json([
                    'message'=>'The table is empty'
                ],404);
            }

            return response()->json([
                'message'=>'All cart detail records retrieved successfully',
                'cartDetails'=>$cartDetails
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
     * Retrieve specific cart by id
     */
    public function show($id)
    {
        try{

            $cartDetail = CartDetail::where('cart_id',$id)->get();

            if($cartDetail->isEmpty())
            {
                return response()->json([
                    'message'=>'Cart Detail not found'
                ],404);
            }

            return response()->json([
                'message'=>'Cart Detail retrieved successfully',
                'cartDetail'=>$cartDetail
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
     * Remove specific cart detail
     */
    public function destroy($id)
    {
        try{

            $cartDetail = CartDetail::find($id);

            if(!$cartDetail)
            {
                return response()->json([
                    'message'=>'Cart detail not found'
                ],404);
            }

            $cartDetail->delete();

            return response()->json([
                'message'=>'Cart detail deleted successfully'
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
     * Store newly created cart detail to cart
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'cart_id'=>'required|integer',
                'product_id'=>'required|integer',
                'quantity'=>'required|integer'
            ]);

            $existingDetail = CartDetail::where('cart_id',$validatedData['cart_id'])
            ->where('product_id',$validatedData['product_id'])
            ->first();

            if($existingDetail)
            {
                $existingDetail->quantity += $validatedData['quantity'];
                $existingDetail->save();

                return response()->json([
                    'message'=>'The item already exist in the cart. Quantity added',
                ],200);
                
            }else
            {
                $cartDetail = CartDetail::create($validatedData);

                return response()->json([
                    'message'=>'Cart detail created successfully',
                    'cartDetail'=>$cartDetail
                ],201);
            }

        }catch(ValidationException $e)
        {
            return response()->json([
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
