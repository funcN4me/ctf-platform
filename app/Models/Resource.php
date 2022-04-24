<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'content'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
