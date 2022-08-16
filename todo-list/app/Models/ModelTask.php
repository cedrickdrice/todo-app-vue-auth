<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTask extends Model
{
    use HasFactory;

    protected $table = 'task';

    protected $with = ['priority', 'status'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'task_status_id',
        'task_priority_id',
        'task_title',
        'task_description',
        'task_order',
        'due_date'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(ModelTaskStatus::class, 'task_status_id');
    }

    public function priority()
    {
        return $this->belongsTo(ModelTaskPriority::class, 'task_priority_id');
    }
}
