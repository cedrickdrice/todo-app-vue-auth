<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface TaskStatusRepositoryInterface
{
    public function getById($Id);

    public function getStatusByColumnName(string $sColumnName, string $sValue): Builder;
}
