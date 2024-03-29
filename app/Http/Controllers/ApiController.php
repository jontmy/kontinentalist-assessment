<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function retrieveAllPosts()
    {
        $posts = Post::get()->toJson(JSON_PRETTY_PRINT);
        return response($posts, 200);
    }

    public function retrievePost($id)
    {
        // Check that the post exists.
        if (!Post::where('id', $id)->exists()) {
            return response()->json([
                "message" => "Post not found."
            ], 404);
        }
        $post = Post::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($post, 200);
    }

    public function createPost(Request $request)
    {
        // Validate the request - title and content are required.
        if (empty($request->title) || empty($request->content)) {
            return response()->json([
                "message" => "Please fill both the `title` and `content` fields."
            ], 422);
        }
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return response()->json([
            "message" => "Post created."
        ], 201);
    }

    public function updatePost(Request $request, $id)
    {
        // Validate the request - either the title or content is required.
        if (empty($request->title) && empty($request->content)) {
            return response()->json([
                "message" => "Please fill either the `title` or `content` field."
            ], 422);
        }
        // Check that the post exists.
        if (!Post::where('id', $id)->exists()) {
            return response()->json([
                "message" => "Post not found."
            ], 404);
        }
        $post = Post::find($id);
        $post->title = is_null($request->title) ? $post->title : $request->title;
        $post->content = is_null($request->content) ? $post->content : $request->content;
        $post->save();

        return response()->json([
            "message" => "Post updated successfully."
        ], 200);
    }

    public function deletePost($id)
    {
        // Check that the post exists.
        if (!Post::where('id', $id)->exists()) {
            return response()->json([
                "message" => "Post not found."
            ], 404);
        }
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            "message" => "Post deleted."
        ], 200);
    }
}
