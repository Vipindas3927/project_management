<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $fillable = ['task_id', 'remark'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
