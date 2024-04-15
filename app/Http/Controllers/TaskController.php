<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Traits\Comments;
use Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    use Comments; 
    public function createTask(Request $request)
    {
        try{
            DB::beginTransaction();
            $task = new Task;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->due_date = $request->due_date;
            $task->created_by = Auth::user()->id;
            $task->save();
            DB::commit();
            if($request->assign_to){
                $task->users()->sync($request->assign_to);
            }
            $members = $task->users()->get();
            return response()->json([
                "message" => "Task created",
                "task" => $task,
                "members" => $members
            ], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json([
                "message" => $e
            ], 401);
        }
        
    }

    public function getAllTasks()
    {
        $user = User::find(Auth::user()->id);
        $tasks = $user->tasks;
        return response()->json([
            "message" => "All Your Tasks",
            "tasks" => $tasks
        ], 200);
    }

    public function viewTask($id)
    {
        $task = Task::find($id);
        if($task){
            $todos = $task->todos;
            $members = $task->users;
            return response()->json([
                'message' => 'Task fetched',
                'task' => $task,
                'taskTodos' => $todos,
                'taskMembers' => $members,
                'comments' => $task->comments
            ], 200);
        }
        return response()->json([
            'message' => 'Task does not exists',
        ], 200);
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::find($id);
        if($task)
        {
            $task->title = is_null($request->title) ? $task->title : $request->title; 
            $task->description = is_null($request->description) ? $task->description : $request->description; 
            $task->due_date = is_null($request->due_date) ? $task->due_date : $request->due_date;
            $task->update();
            if($request->assign_to)
            {
                $task->users()->sync($request->assign_to);
            }
            return response()->json([
                'message' => 'Task updated',
                'task' => $task
            ], 200);
        }
        return response()->json([
            "message" => "Task Does not Exist"
        ], 200);
    }

    public function deleteTask ($id)
    {
        $task = Task::find($id);
        if($task){
            $task->delete();
            return response()->json([
                "message" => "Task Deleted"
            ], 200);
        }else {
            return response()->json([
                "message" => "Task has already been delete"
            ],404);
        }
    }

    public function disableTask(Request $request, $id)
    {
        $validated = Validator::make($request->all(),[
            'is_active' => 'required|boolean',
        ]);
        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }
        $task = Task::find($id);
        if($task->is_active == 1)
        {
            $task->is_active = 0;
            $task->update();
            return response()->json([
                "message" => "Task Disabled"
            ], 200);
        }
        return response()->json([
            "message" => "Task does not exist or already disabled"
        ], 200);

    }

    public function setTaskStatus(Request $request, $id)
    {
        $validated = Validator::make($request->all(),[
            'status' => 'required|',
        ]);
        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }
        $task = Task::find($id);
        if($task)
        {
            $task->status = $request->status; //1 complete 0 incomplete
            $task->update();
            return response()->json([
                "message" => "Task Status Updated"
            ], 200);
        }
        return response()->json([
            "message" => "Task does not exist"
        ], 200);
    }

    public function addCommentToTask(Request $request, $id)
    {
        $entity = Task::find($id);
        if(!$entity)
        {
            return response()->json([
                "message" => "Entity Not Found"
            ], 422);
        }
        $this->addComment($request, $entity);
        return response()->json([
                "message" => "success"
        ], 200);
    }
    public function editTaskComment()
    {
        
    }
}
