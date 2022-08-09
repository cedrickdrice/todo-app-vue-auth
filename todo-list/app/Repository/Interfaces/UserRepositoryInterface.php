<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface UserRepositoryInterface
{
    /**
     * Create Eloquent
     * @param array $aAttributes
     * @return Model
     */
    public function create(array $aAttributes): Model;

    /**
     * Get User by column name search
     * @param string $sColumnName
     * @param string $sValue
     * @return mixed
     */
    public function getUserByColumnName(string $sColumnName, string $sValue): Builder;
}
