<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    //belongs to user
    public function users(){
        return $this->belongsToMany(User::class);
    }

    // has many todo
    public function todos(){
        return $this->hasMany(Todo::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'entity');
    }
}
