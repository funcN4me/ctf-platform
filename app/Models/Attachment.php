<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
