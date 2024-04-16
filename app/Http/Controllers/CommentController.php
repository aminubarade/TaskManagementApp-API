<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function editComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        if($comment){
            $comment->comment = $request->comment;
            $comment->update();
            return response()->json([
                "message" => "Comment Edited"
            ], 201);
        }
        return response()->json([
            "message" => "Error"
        ], 401);
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if($comment){
            $comment->delete();
            return response()->json([
                "message" => "Comment Deleted"
            ], 201);
        }
        return response()->json([
            "message" => "Error"
        ], 401);

    }
}
