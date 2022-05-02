<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function getResourcesAttribute()
    {
        $tasks = $this->tasks;
        $resources = [];
        foreach ($tasks as $task) {
            foreach ($task->resources as $resource) {
                if (!in_array($resource, $resources)) {
                    $resources[] = $resource;
                }
            }
        }
        return $resources;
    }
}
