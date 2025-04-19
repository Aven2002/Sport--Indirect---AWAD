<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Retrieve all user records
     */
    public function index()
    {
        try{
            $users = User::all();

            if($users->isEmpty())
            {
                return response()->json([
                    'message'=>'User table is empty',
                ],200);
            }

            return response()->json([
                'message'=>'User records retrieved successfully',
                'users'=>$users
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
     * Retrieve specific user record
     */
    public function show($id)
    {
        try{
            $user = User::find($id);

            if(!$user)
            {
                return response()->json([
                    'message'=>'User record not found',
                ],200);
            }

            return response()->json([
                'message'=>'User record retrieved successfully',
                'user'=>$user
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
     * Remove specific user record
     */
    public function destroy($id)
    {
        try{
            $user = User::find($id);

            if(!$user)
            {
                return response()->json([
                    'message'=>'User record not found',
                ],200);
            }

            $user->delete();

            return response()->json([
                'message'=>'User record deleted successfully',
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
     * Update specific user status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            // Find the user by ID
            $user = User::find($id);

            // Handle if user not found
            if (!$user) {
                return response()->json([
                    'message' => 'User record not found'
                ], 404);
            }

            // Validate the status field
            $validatedData = $request->validate([
                'status' => 'required|in:active,frozen'
            ]);

            // Update the user's status
            $user->update([
                'status' => $validatedData['status']
            ]);

            return response()->json([
                'message' => 'User status updated successfully',
                'user' => $user
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => "Validation error",
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update profile img
     */
   public function updateImage(Request $request)
   {
       // Validate the selected image and user_id
       $request->validate([
           'selected_image' => 'required|string',
           'user_id' => 'required|integer|exists:users,id', // Ensure user_id is valid
       ]);
   
       // Retrieve the user by user_id
       $user = User::find($request->user_id); // Find the user by ID
   
       if (!$user) {
           return response()->json(['error' => 'User not found'], 404);
       }
   
       // Update the user's profile image path
       $user->imgPath = 'images/Profile_Img/' . $request->selected_image;
       $user->save();
   
       return response()->json(['status' => 'success', 'message' => 'Profile image updated']);
   }

       /**
         * Search engine
         */
        public function search(Request $request)
        {
            $searchTerm = $request->input('search');

            $accounts = User::where('email', 'like', '%' . $searchTerm . '%')->get();

            return response()->json($accounts);
        }
     

}
