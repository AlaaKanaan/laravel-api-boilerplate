<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::where('user_id', auth()->id())->get();

        return $this->respond($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);

        return $this->respond($post, 201);
    }

    public function show(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return $this->respondError('Unauthorized', 403);
        }

        return $this->respond($post);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return $this->respondError('Unauthorized', 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'published_at' => 'nullable|date',
        ]);

        $post->update($validated);

        return $this->respond($post);
    }

    public function destroy(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return $this->respondError('Unauthorized', 403);
        }

        $post->delete();

        return $this->respond(null, 204);
    }

    private function respond($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    private function respondError($message, $status)
    {
        return response()->json(['error' => $message], $status);
    }
}
