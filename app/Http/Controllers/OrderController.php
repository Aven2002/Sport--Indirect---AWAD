<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Retrieve all order records
     */
    public function index()
    {
        try{

            $orders = Order::all();

            if($orders->isEmpty())
            {
                return response()->json([
                    'message'=>'The table is empty'
                ],404);
            }

            return response()->json([
                'message'=>'All order records retrieved successfully',
                'orders'=>$orders
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
     * Retrieve specific order record
     */
    public function show($id)
    {
        try{

            $order = Order::find($id);

            if(!$order)
            {
                return response()->json([
                    'message'=>'Order record not found'
                ],404);
            }

            return response()->json([
                'message'=>'Order record retrieved successfully',
                'order'=>$order
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
     * Remove specific order record
     */
    public function destroy($id)
    {
        try{
            $order = Order::find($id);

            if(!$order)
            {
                return response()->json([
                    'message'=>'Order record not found'
                ],404);
            }

            $order->delete();

            return response()->json([
                'message'=>'Order record deleted successfully',
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
     * Store a newly created order record
     */
    public function store(Request $request)
    {
        try{

            $validatedData = $request->validate([
                'user_id'=>'required|integer',
                'address_id'=>'required|integer',
                'totalPrice'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'paymentMethod'=>'required|string',
                'status'=>'nullable|string'
            ]);

            $order = Order::create($validatedData);

            return response()->json([
                'message'=>'Order record created successfully',
                'order'=>$order
            ],201);

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

    /**
     * Update specific order record
     */
    public function update(Request $request, $id)
    {
        try{
            $order = Order::find($id);

            if(!$order)
            {
                return response()->json([
                    'message'=>'Order record not found',
                ],404);
            }
               
            $validatedData = $request->validate([
                'user_id'=>'required|integer',
                'address_id'=>'required|integer',
                'totalPrice'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'paymentMethod'=>'required|string',
                'status'=>'nullable|string'
            ]);

            $order->update($validatedData);

            return response()->json([
                'message'=>'Order record updated successfully',
                'order'=>$order
            ],200);

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
