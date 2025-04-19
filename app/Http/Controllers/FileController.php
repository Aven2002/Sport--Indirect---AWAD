<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        try {
            Log::info('Upload Request', $request->all());
            Log::info('File Present:', [$request->hasFile('image')]);

            if (!$request->hasFile('image')) {
                return response()->json(['message' => 'No image uploaded'], 400);
            }

            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
            ]);

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/upload'), $filename);

            $filePath = 'images/upload/' . $filename;

            return response()->json(['imgPath' => $filePath], 200);
        } catch (\Exception $e) {
            Log::error('Upload failed', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Upload failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
