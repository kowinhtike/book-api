<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class PostsController extends Controller
{
    //

    //
    public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
    }
    public function show($id)
    {
        $post = Post::find($id);
        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        if ($post->save()) {
            return response()->json([
                'success' => "Post Created Successfully",
                'data' => $post
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->body = $request->body;
        if ($post->save()) {
            return response()->json([
                'success' => "Post Updated Successfully",
                'data' => $post
            ]);
        }
    }

    public function delete($id)
    {
        Post::find($id)->delete();

        return response()->json([
            'success' => "Post Deleted Successfully",
            'data' => []
        ]);
    }

    public function userId(Request $request)
    {
        $tokenId = $request->bearerToken(); // Get token from request header
        $token = PersonalAccessToken::findToken($tokenId);
        $user = $token->tokenable;
        return $user->userId;
    }
}
