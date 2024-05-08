<?php
namespace App\Traits;

use App;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Auth;

trait Comments
{
    public function addComment(Request $request, $entity)
    {
        try{
            DB::beginTransaction();
            $comment = new Comment;
            $comment->comment = $request->comment;
            $comment->user_id = Auth::user()->id;
            $comment->entity_id = $entity->id;
            $comment->entity_type = get_class($entity);
            $comment->save();
            DB::commit();
            return response()->json([
                "message"=> "Comment Added",
                "comment" => $comment
            ], 201);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                "message" => $e
            ], 401);
        }
        
    }

    public function getAllComments($entity)
    {
        $comments = Comment::where('entity_id', $entity_id);
        if($comments){
            return response()->json([
                "message" => "All comments fetched",
                "comments" => $comments
            ], 200);
        }
        return response()->json([
            "message" => "No comment yet"
        ], 400);
    }

    public function editComment($id)
    {
        
    }

    public function deleteComment($id)
    {
        
    }
}
