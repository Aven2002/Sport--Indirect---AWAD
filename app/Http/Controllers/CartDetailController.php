<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\CartDetail;

class CartDetailController extends Controller
{

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
                ],200);
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
        try {
            $validatedData = $request->validate([
                'items' => 'required|array|min:1',
                'items.*.cart_id' => 'required|integer',
                'items.*.product_id' => 'required|integer',
                'items.*.size' => 'nullable|string',
                'items.*.quantity' => 'required|integer|min:1'
            ]);

            foreach ($validatedData['items'] as $item) {
                $existingDetail = CartDetail::where('cart_id', $item['cart_id'])
                    ->where('product_id', $item['product_id'])
                    ->where('size', $item['size'])
                    ->first();

                if ($existingDetail) {
                    $existingDetail->quantity += $item['quantity'];
                    $existingDetail->save();
                } else {
                    CartDetail::create($item);
                }
            }

            return response()->json([
                'message' => 'Cart items processed successfully.'
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
