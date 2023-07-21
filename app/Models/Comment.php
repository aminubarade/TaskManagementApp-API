<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    //belongs to a user
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    //belongs to as task
    public function task(){
        return $this->belongsTo(Task::class);
    }
}
