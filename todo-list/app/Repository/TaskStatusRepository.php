<?php

namespace App\Repository;

use App\Models\ModelTaskStatus;
use App\Repository\Interfaces\TaskStatusRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TaskStatusRepository extends BaseRepository implements TaskStatusRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param ModelTaskStatus $oModel
     */
    public function __construct(ModelTaskStatus $oModel)
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
    public function getStatusByColumnName(string $sColumnName, string $sValue): Builder
    {
        return $this->oModel->where($sColumnName, $sValue);
    }
}
