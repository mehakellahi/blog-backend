<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // Retrieve all posts with pagination if needed
        return response()->json(Post::all(), 200);
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
            'slug' => 'nullable|string|unique:posts',
            'author' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);
        
        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public'); // Store in "public/posts"
        }

        // Create a new post
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'slug' => $request->slug,
            'author' => $request->author,
            'image' => $imagePath ? Storage::url($imagePath) : null, // Store image URL or null
        ]);

        // Return the created post as a response
        return response()->json($post, 201);
    }

    public function show($id)
    {
        // Return a single post by ID
        return response()->json(Post::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'nullable|string',
            'slug' => 'nullable|string',
            'author' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        // Find the post
        $post = Post::findOrFail($id);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($post->image) {
                Storage::delete(str_replace('/storage/', 'public/', $post->image));
            }
            // Store the new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = Storage::url($imagePath);
        }

        // Update the post with the new data
        $post->update($request->only(['title', 'content', 'category', 'slug', 'author']));

        // Return the updated post
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        // Find and delete the post
        $post = Post::findOrFail($id);
        
        // Delete the image file if exists
        if ($post->image) {
            Storage::delete(str_replace('/storage/', 'public/', $post->image));
        }

        $post->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
