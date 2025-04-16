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
     * Update specific user record
     */
    public function update(Request $request, $id)
    {
        try{

            $user = User::find($id);

            if($user)
            {
                return response()->json([
                    'message'=>'User record not found'
                ],200);
            }

            $validatedData = $request->validate([
                'email'=>'required|string',
                'username'=>'required|string',
                'password'=>'required|string',
                'dob'=>'required|date',
                'profileImg'=>'required|string',
                'security_answers'=>'required|text',
            ]);

            $user->update($validatedData);

            return response()->json([
                'message'=>'User record updated successfully',
                'user'=>$user
            ],200);

        }catch(ValidationException $e)
        {
            return response()->json([
                'message'=>"Validation error",
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
