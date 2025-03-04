<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['project_id', 'name', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }
}
