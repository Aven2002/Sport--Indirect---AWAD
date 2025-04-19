<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

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
                ],200);
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
     * Retrieve record own by specific user
     */
    public function getUserOrder($id)
    {
        try {
            $orders = Order::with('orderDetail')->where('user_id', $id)->get();
    
            if ($orders->isEmpty()) {
                return response()->json([
                    'message' => 'You have not placed any orders yet.',
                    'order' => [],
                ], 200);
            }
    
            return response()->json([
                'message' => 'Orders retrieved successfully',
                'order' => $orders
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }    

    /**
     * Retrieve specific order record
     */
    public function show($id)
    {
        try{

            $order = Order::with('orderDetail')->find($id);

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
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'address_id' => 'required|integer',
                'totalPrice' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'paymentMethod' => 'required|string',
                'status' => 'nullable|string',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|integer',
                'items.*.size' => 'nullable|string',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.subPrice' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            ]);

            // Create the order
            $order = Order::create([
                'user_id' => $validatedData['user_id'],
                'address_id' => $validatedData['address_id'],
                'totalPrice' => $validatedData['totalPrice'],
                'paymentMethod' => $validatedData['paymentMethod'],
                'status' => $validatedData['status'] ?? 'Processing',
            ]);

            // Loop through items and insert into order_details
            foreach ($validatedData['items'] as $item) {

                Log::info('Processing item for order', [
                    'product_id' => $item['product_id'],
                    'size' => $item['size'] ?? null
                ]);

                $order->orderDetail()->create([
                    'order_id'=>$order->id,
                    'product_id' => $item['product_id'],
                    'size' => $item['size'] ?? null,
                    'quantity' => $item['quantity'],
                    'subPrice' => $item['subPrice'],
                ]);
            }

            return response()->json([
                'message' => 'Order created successfully with all item details.',
                'order' => $order->load('orderDetail')
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
