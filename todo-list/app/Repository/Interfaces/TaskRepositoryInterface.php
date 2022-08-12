<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface TaskRepositoryInterface
{
    public function create(array $aAttributes): Model;

    public function getTasksCount(string $sColumnName, string $sValue);
}
