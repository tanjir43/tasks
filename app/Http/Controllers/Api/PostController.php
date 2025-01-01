<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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
}
