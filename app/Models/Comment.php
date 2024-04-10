<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public function entity()
    {
        return $this->morphTo(__FUNCTION__, 'entity', 'entity_id');
    }
}
