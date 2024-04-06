<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Auth;

class TaskController extends Controller
{
   public function createTask(Request $request)
   {
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->created_by = Auth::user()->id;
        $task->save();
        if($request->assign_to){
            $task->users()->sync($request->assign_to);
        }
        $members = $task->users();
        return response()->json([
            "message" => "Task created",
            "task" => $task,
            "members" => $members
        ], 200);
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
                'taskMembers' => $members
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
                "message" => "Uask has already been delete"
            ],404);
        }
   }

   public function disableTask(Request $request, $id)
   {
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
}
