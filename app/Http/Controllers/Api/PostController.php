<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // get publish data
    public function getPublishedData()
    {
        $posts = Post::published()->get();

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    // get draft data
    public function getDraftData()
    {
        $posts = Post::draft()->get();

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }


    public function getAllData()
    {
        $posts = Post::withTrashed()->get(['id', 'title', 'description', 'status', 'created_at', 'updated_at']);

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    public function createPost(Request $request)
    {
        try {
            $request->validate([
                'title'         => 'required',
                'description'   => 'required',
                'status'        => 'required',
                'category'      => 'required'
            ]);

            $post = new Post();
            $post->title        = $request->title;
            $post->slug         = Str::slug($request->title);

            $slug = $post->slug;
            $count = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = $post->slug . '-' . $count++;
            }
            $post->slug = $slug;

            $post->category_id  = $request->category;
            $post->description  = $request->description;
            $post->status       = $request->status;
            $post->created_by   = auth()->user()->id;
            $post->published_at = now();

            $post->save();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Post created successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePost(Request $request, $id)
    {
        try {

            $post = Post::findOrFail($id);

            $post->title        = $request->title;
            $post->slug         = Str::slug($request->title);

            $slug = $post->slug;
            $count = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = $post->slug . '-' . $count++;
            }
            $post->slug = $slug;

            $post->category_id  = $request->category_id;
            $post->description  = $request->description;
            $post->status       = $request->status;
            $post->updated_by   = auth()->user()->id;

            $post->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Post updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the post: ' . $e->getMessage()
            ], 500);
        }
    }


    public function deletePost($id)
    {
        try {
            $post = Post::findOrFail($id);

            $post->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Post deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the post: ' . $e->getMessage()
            ], 500);
        }
    }


}
