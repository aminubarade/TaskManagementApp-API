<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    //has many tasks
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    //has many todo
}