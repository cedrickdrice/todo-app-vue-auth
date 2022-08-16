<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface TaskPriorityRepositoryInterface
{
    public function getById($Id);

    public function getPriorityByColumnName(string $sColumnName, string $sValue): Builder;
}
