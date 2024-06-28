<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Auth;

class TodoController extends Controller
{
    public function createTodo(Request $request)
    {
        //validation
        try{
            DB::beginTransaction();
            $todo = new Todo;
            $todo->title = $request->title;
            $todo->task_id = $request->task_id;
            $todo->user_id = Auth::user()->id;
            $todo->save();
            DB::commit();
            return response()->json([
                "message" => "Todo Created",
                "todo" => $todo
            ], 201);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                "message" => $e
            ], 401);
        }
    }

    public function updateTodo(Request $request, $id)
    {
        $todo = Todo::find($id);
        if($todo)
        {
            $todo->title = is_null($request->title) ? $todo->title : $request->title; 
            $todo->task_id = is_null($request->task_id) ? $todo->task_id : $request->task_id; 
            $todo->update();
            return response()->json([
                'message' => 'Todo updated',
                'task' => $todo
            ], 200);
        }
        return response()->json([
            "message" => "Todo Does not Exist"
        ], 404);
    }
    
    public function deleteTodo($id)
    {
        $todo = Todo::find($id);
        if($todo){
            $todo->delete();
            return response()->json([
                "message" => "Todo Deleted"
            ], 200);
        }else {
            return response()->json([
                "message" => "Todo has already been delete"
            ],404);
        }
    }

    public function updateTodoStatus(Request $request, $id)
    {
        $validated = Validator::make($request->all(),[
            'status' => 'required|boolean',
        ]);
        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }
        $todo = Todo::find($id);
        if($todo)
        {
            $todo->status = $request->status;//1 complete 0 incomplete
            $todo->update();
            return response()->json([
                "message" => "Todo Status Updated"
            ], 200);
        }
        return response()->json([
            "message" => "Todo does not exist"
        ], 404);
    }

    public function convertTodoToTask(Request $request, $id)
    {
        $todo = Todo::find($id);
        if($todo)
        {
            try{
                DB::beginTransaction();
                $task = new Task;
                $task->title = $todo->title;
                $task->description = $todo->title;
                $task->due_date = $todo->date_created;
                $task->created_by = Auth::user()->id;
                $task->save();
                DB::commit();
                if($request->assign_to){
                    $task->users()->sync($request->assign_to);
                }
                $members = $task->users()->get();
                return response()->json([
                    "message" => "Todo Has been converted to task.",
                    "task" => $task,
                    "members" => $members
                ], 201);
            }
            catch(Exception $e){
                DB::rollBack();
                return response()->json([
                    "message" => $e
                ], 401);
            }
        }
        return response()->json([
            "message" => "Todo does not exist"
        ], 404);
    }

}

