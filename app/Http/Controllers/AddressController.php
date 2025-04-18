<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Retrieve all address records
     */
    public function index()
    {
        try{
            $address = Address::all();

            if ($address->isEmpty())
            {
                return response()->json([
                    'message'=> 'The table is empty'
                ],404);
            }

            return response()->json([
                'message'=>'All address records retrieved successfully',
                'address'=>$address
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
     * Retrieve specific address record
     */
    public function show($id)
    {
        try{
            $address = Address::find($id);

            if(!$address)
            {
                return response()->json([
                    'message'=>'Address record not found'
                ],404);
            }

            return response()->json([
                'message'=>'Address record retrieve successfully',
                'address'=>$address
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
     * Retrieve the list of adressess own by the user
     */
    public function getUserAddress($id)
    {
        try{
            $addresses = Address::where('user_id', $id)
                            ->orderByDesc('isDefault')
                            ->get();

            if($addresses->isEmpty())
            {
                return response()->json([
                    'message'=> 'No address found for this user'
                ],200);
            }

            return response()->json([
                'message'=>'User addresses retrieved successfully',
                'addresses'=>$addresses
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
     * Remove the specified address 
     */
    public function destroy($id)
    {
        try{
            $address = Address::find($id);

            if(!$address)
            {
                return response()->json([
                    'message'=>'Address record not found'
                ],404);
            }

            $address->delete();

            return response()->json([
                'message'=>'Address record deleted successfully'
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
     * Store a newly created address
     */
    public function store(Request $request)
    {
        try{

            $validatedData = $request->validate([
                'user_id'=>'required|integer',
                'name'=>'required|string|max:50',
                'phoneNo' => 'required|string|max:20',
                'addressLine' => 'required|string',
                'city' => 'required|string|max:50',
                'state' => 'required|string|max:50',
                'postcode' => 'required|digits:5',
                'isDefault' => 'boolean'
            ]);

            if (!empty($validatedData['isDefault']) && $validatedData['isDefault']) {
                Address::where('user_id', $validatedData['user_id'])
                    ->where('isDefault', true)
                    ->update(['isDefault' => false]);
            }

            $address = Address::create($validatedData);

            return response()->json([
                'message'=>'Address record created successfully',
                'address'=>$address
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
     * Update the specific address record
     */
    public function update(Request $request, $id)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'phoneNo' => 'required|string|max:20',
                'addressLine' => 'required|string',
                'city' => 'required|string|max:50',
                'state' => 'required|string|max:50',
                'postcode' => 'required|digits:5',
                'isDefault' => 'boolean'
            ]);

            // Find the address by its ID
            $address = Address::find($id);

            // Check if the address exists
            if (!$address) {
                return response()->json([
                    'message' => 'Address not found'
                ], 404);
            }

            $address->update($validatedData);

            return response()->json([
                'message'=>'Address record updated successfully',
                'address'=>$address
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

    public function setDefault($id)
    {
        try {
            $address = Address::find($id);

            if (!$address) {
                return response()->json(['message' => 'Address not found'], 404);
            }

            // Unset current default for the same user
            Address::where('user_id', $address->user_id)
                ->where('isDefault', true)
                ->update(['isDefault' => false]);

            // Set this one as default
            $address->isDefault = true;
            $address->save();

            return response()->json(['message' => 'Default address updated successfully'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
