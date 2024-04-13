<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PemilikPostingan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd('Middleware PemilikPostingan');

        $currentUser = Auth::user();
        $post = Post::findOrFail($request->id);
        if ($currentUser->id !== $post->author) {
            return response()->json([
                'message' => 'Anda bukan pemilik postingan ini'
            ], 403);
        }

        return $next($request);
    }
}
