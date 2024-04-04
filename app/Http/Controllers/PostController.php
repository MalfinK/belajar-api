<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;

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
        return PostResource::collection($post); // Collection untuk menampilkan banyak data
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
}
