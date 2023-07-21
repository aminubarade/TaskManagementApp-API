<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    //belongs to task
    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }

    //belongs to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
