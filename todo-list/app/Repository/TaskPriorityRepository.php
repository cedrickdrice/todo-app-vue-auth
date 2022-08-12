<?php

namespace App\Repository;

use App\Models\ModelTaskPriority;
use App\Repository\Interfaces\TaskPriorityRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TaskPriorityRepository extends BaseRepository implements TaskPriorityRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param ModelTaskPriority $oModel
     */
    public function __construct(ModelTaskPriority $oModel)
    {
        $this->oModel = $oModel;
    }

    public function getById($Id)
    {
        return $this->oModel->find($Id);
    }

    /**
     * Get Priority by column name search
     * @param string $sColumnName
     * @param string $sValue
     * @return mixed
     */
    public function getPriorityByColumnName(string $sColumnName, string $sValue): Builder
    {
        return $this->oModel->where($sColumnName, $sValue);
    }
}
