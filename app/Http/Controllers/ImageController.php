<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Upload image for WYSIWYG editor
     */
    public function upload(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'image' => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);
            
            $image = $request->file('image');
            
            // Additional security checks
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            
            if (!in_array($image->getMimeType(), $allowedMimes)) {
                throw ValidationException::withMessages([
                    'file' => 'Invalid file type. Only images are allowed.'
                ]);
            }
            
            if (!in_array(strtolower($image->getClientOriginalExtension()), $allowedExtensions)) {
                throw ValidationException::withMessages([
                    'file' => 'Invalid file extension.'
                ]);
            }
            
            // Generate unique filename
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            
            // Define the storage path
            $directory = 'posts/images/' . date('Y/m');
            $path = $directory . '/' . $filename;

            // Store using Storage facade
            Storage::disk('public')->putFileAs(
                $directory,
                $image,
                $filename
            );

            // Generate the public URL for the stored image
            $url = asset('storage/' . $path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path, // Store this for potential cleanup later
                'filename' => $filename
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image'
            ], 500);
        }
    }

    /**
     * Delete an uploaded image (optional cleanup method)
     */
    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        try {
            $path = $request->path;
            
            // Security: Only allow deletion of files in posts/images directory
            if (!str_starts_with($path, 'posts/images/')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file path'
                ], 422);
            }
            
            // Prevent path traversal attacks
            if (str_contains($path, '..') || str_contains($path, '/./') || str_contains($path, '\\\\')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file path'
                ], 422);
            }
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image'
            ], 500);
        }
    }
}