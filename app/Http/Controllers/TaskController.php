<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index()
    {
        //
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = Validator::make($request->all(),[
            'task' => 'required|unique:users|max:255',
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }else{
            $task = new Task;
            $task->task = $request->username;
            $task->status = null;
            $task->user_id = null;
            $task->save();
            return response()->json([
                "message" => "Task successfully created"
            ],201);
        }

    }


    public function show(Task $task)
    {
        return $task;

    }

    public function update(UpdateUserRequest $request, Task $task)
    {
        //
        if($task->task){
            $task->task = is_null($request->task) ? $task->task : $request->task; 
            $task->status = is_null($request->status) ? $task->status : $request->status; 
            $task->update();
            return response()->json([
                "message" => "Task updated successfully"
            ],201);
        }
    }

    public function setStatus(){

    }


    public function destroy(Task $task)
    {
        //
    }
}
