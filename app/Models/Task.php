<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    //belongs to user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // has many todo
    public function todos(){
        return $this->hasMany(Todo::class);
    }
}
