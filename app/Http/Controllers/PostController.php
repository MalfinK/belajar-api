<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::all();
        // Default response
        /* return response()->json([
            'data' => $post
        ]); */

        // Dengan menggunakan PostResource
        // return PostResource::collection($post); // Collection untuk menampilkan banyak data

        // Dengan menggunakan PostDetailResource
        return PostDetailResource::collection($post->loadMissing('writer:id,username')); // Collection untuk menampilkan banyak data

        /*
        Note :
        Kalau mau nambahin relasinya di return harus pakai loadMissing() nah kalau mau nambahinnya menggunakan with() variabel post harus diubah jadi $post = Post::with('writer:id,username')->get(); dan return nya ga perlu dirubah
        */
    }

    public function show($id)
    {
        // Tanpa relasi
        // $post = Post::findOrFail($id);

        // Dengan relasi
        // Cara 1
        // $post = Post::findOrFail($id)->load('writer');
        // Cara 2
        // $post = Post::findOrFail($id)->with('writer')->first();
        // Cara 3
        // $post = Post::with('writer')->findOrFail($id);

        // Kalaupun kita hanya ingin menampilkan beberapa field saja dari tabel users
        // Cara 1
        /* $post = Post::with(['writer' => function($query) {
            $query->select('id', 'username');
        }])->findOrFail($id); */
        // Cara 2
        $post = Post::with('writer:id,username')->findOrFail($id);

        // Default response
        /* return response()->json([
            'data' => $post
        ]); */

        // Dengan menggunakan PostResource
        // return new PostResource($post); // Single data
        return new PostDetailResource($post); // Single data
    }

    public function show2($id)
    {

        $post = Post::findOrFail($id);
        return new PostDetailResource($post); // Single data
    }

    public function store(Request $request)
    {
        // return response()->json("Bisa akses store");

        $validate = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required'
        ]);

        // Cara sendiri
        /* $post = Post::create([
            'title' => $validate['title'],
            'news_content' => $validate['news_content'],
            'author' => Auth::id()
        ]);

        return response()->json([
            'message' => 'Post created',
            'data' => $post
        ]); */

        // Cara video
        // $request['author'] = Auth::user()->id;
        $request['author'] = Auth::id();
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request, $id)
    {
        // dd('Ini update');
        $validate = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required'
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json([
            'message' => 'Post deleted'
        ]);
    }
}
