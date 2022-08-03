<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTaskHasTags extends Model
{
    use HasFactory;

    protected $table = 'task_has_tags';
}
