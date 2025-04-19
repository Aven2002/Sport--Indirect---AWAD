<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    /**
     * Retrieve all feedback records
     */
    public function index()
    {
        try{
            $feedbacks = Feedback::all();

            if($feedbacks->isEmpty())
            {
                return response()->json([
                    'message'=>'The table is empty'
                ],200);
            }

            return response()->json([
                'message'=>'All feedback records retrieved successfully',
                'feedback'=>$feedbacks
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
     * Retrive specific feedback
     */
    public function show($id)
    {
        try{
            $feedback = Feedback::find($id);

            if(!$feedback)
            {
                return response()->json([
                    'message'=>'Feedback record not found'
                ],200);
            }
            return response()->json([
                'message'=>'Feedback record retrieved successfully',
                'feedback'=>$feedback
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
     * Remove the specific feedback
     */
    public function destroy($id)
    {
        try{
            $feedback = Feedback::find($id);

            if(!$feedback)
            {
                return response()->json([
                    'message'=>'Feedback record not found'
                ],404);
            }

            $feedback->delete();

            return response()->json([
                'message'=>'Feedback record deleted successfully'
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
     * Store a newly creted feedback
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email',
                'subject' => 'required|string',
                'message' => 'required'
            ]);

            $feedback = Feedback::create($validatedData);

            return response()->json([
                'message'=>'Feedback created successfully',
                'feedback'=>$feedback
            ],201);

        }catch(ValidationException $e)
        {
            return response()->json([
                'message'=>'Validation error',
                'errors'=>$e->errors()
            ],422);

        }
        catch(\Exception $e)
        {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Update feedback's status (Read || Unread)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $feedback = Feedback::find($id);

            if (!$feedback) { 
                return response()->json([
                    'message' => 'Feedback not found'
                ], 404);
            }

            $request->validate([
                'status' => 'required|boolean'
            ]);

            // Update status
            $feedback->status = $request->status;
            $feedback->save();

            return response()->json([
                'message' => 'Feedback status updated successfully',
                'feedback' => $feedback
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Count the unread feedback
     */
    public function unreadCount()
    {
        $unreadFeedbacks = Feedback::where('status', false)->pluck('id');

        return response()->json([
            'unread_count' => $unreadFeedbacks->count(),
            'unread_ids' => $unreadFeedbacks
        ]);
    }
}
