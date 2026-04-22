<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() 
    {
        return response()->json(Post::with('user')->paginate(6));
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return response()->json($post);
    }

    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());
        return response()->json($post, 201);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Вы не можете удалить чужой пост'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Пост успешно удален'], 200);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if($request->user()->id !== $post->user_id) {
            return response()->json([
                'message' => 'У вас нет прав на редактирование этого поста.'
            ], 403);
        }

        $post->update($request->validated());

        return response()->json($post, 200);
    }
}
