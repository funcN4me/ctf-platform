<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnArgument;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'subcategory',
        'description', 'attachments', 'url'
    ];

    protected $hidden = [
        'flag'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

    public function hasResource($resource)
    {
        return $this->resources->contains(Resource::find($resource));
    }
}
