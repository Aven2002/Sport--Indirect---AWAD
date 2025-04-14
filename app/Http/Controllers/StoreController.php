<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Retrieve all the store records
     */
    public function index()
    {
        try{
            $stores = Store::all();

            if($stores->isEmpty())
            {
                return response()->json([
                    'message'=>'The table is empty'
                ],404);
            }

            return response()->json([
                'message'=>'All store records retrieved successfully',
                'stores'=>$stores
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
     * Retreive specific store record
     */
    public function show($id)
    {
        try{
            $store = Store::find($id);

            if(!$store)
            {
                return response()->json([
                    'message'=>'Store record not found'
                ],404);
            }

            return response()->json([
                'message'=>'Store record retrieved successfully',
                'store'=>$store
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
     * Remove specific store record
     */
    public function destroy($id)
    {
        try{

            $store = Store::find($id);

            if(!$store)
            {
                return response()->json([
                    'message'=>'Store record not found'
                ],404);
            }

            $store->delete();

            return response()->json([
                'message'=>'Store record deleted successfully'
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
     * Store a newly created store
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'storeName' => 'required|string|max:50',
                'imgPath' => 'required|string',
                'address' => 'required|string',
                'operation' => 'required|string',
                'contactNum' => 'nullable|string',
            ]);

            $store = Store::firstOrCreate($validatedData);

            return response()->json([
                'message'=>'Store record created successfully',
                'store'=>$store
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
     * Update specific store record
     */
    public function update(Request $request, $id)
    {
        try{
            $store = Store::find($id);

            if(!$store)
            {
                return response()->json([
                    'message'=>'Store record not found'
                ],404);
            }

            $validatedData = $request->validate([
                'storeName' => 'required|string|max:50',
                'imgPath' => 'required|string',
                'address' => 'required|string',
                'operation' => 'required|string',
                'contactNum' => 'nullable|string',
            ]);

            $store->update($validatedData);

            return response()->json([
                'message'=>'Store record updated successfully',
                'store'=>$store
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
