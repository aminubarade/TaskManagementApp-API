<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tasks(){
        return $this->belongsToMany(Task::class);
    }

    //has many todo
    public function todos(){
        return $this->hasMany(Todo::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter(){
        User::get()->latest();
    }
}
