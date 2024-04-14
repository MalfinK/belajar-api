<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id', // exists:posts,id artinya post_id harus ada di tabel posts di kolom id
            'comments_content' => 'required'
        ]);

        // Cara 1 (video)
        $request['user_id'] = auth()->id();
        $comment = Comment::create($request->all());

        // Cara 2
        /* $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'comments_content' => $request->comments_content
        ]); */

        /* return response()->json([
            'message' => 'Comment created',
            'data' => $comment
        ]); */

        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'comments_content' => 'required'
        ]);

        $comment = Comment::findOrFail($id);

        $comment->update($request->only('comments_content'));

        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        return (new CommentResource($comment->loadMissing(['commentator:id,username'])))->additional([
            'message' => 'Comment deleted'
        ]);
    }
}
