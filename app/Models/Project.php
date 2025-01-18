<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany(Task::class)->withTrashed();
    }

    protected static function booted()
    {
        static::deleting(function ($project) {
            $project->tasks()->delete(); // This ensures related tasks are deleted
        });
    }
}
