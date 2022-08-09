<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $oModel
     */
    public function __construct(User $oModel)
    {
        $this->oModel = $oModel;
    }

    /**
     * Create Eloquent
     * @param array $aAttributes
     * @return Model
     */
    public function create(array $aAttributes): Model
    {
        return $this->oModel->create($aAttributes);
    }

    /**
     * Get User by column name search
     * @param string $sColumnName
     * @param string $sValue
     * @return mixed
     */
    public function getUserByColumnName(string $sColumnName, string $sValue): Builder
    {
        return $this->oModel->where($sColumnName, $sValue);
    }
}
