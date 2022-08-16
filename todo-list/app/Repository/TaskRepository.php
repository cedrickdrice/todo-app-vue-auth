<?php

namespace App\Repository;

use App\Models\ModelTask;
use App\Repository\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param ModelTask $oModel
     */
    public function __construct(ModelTask $oModel)
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
     * @param string $taskId
     * @return mixed
     */
    public function getTaskById(string $taskId)
    {
        return $this->oModel->where('id', $taskId)->first();
    }

    /**
     * Where Eloquent
     * @param string $sColumnName
     * @param string $sValue
     * @return Model
     */
    public function query()
    {
        return $this->oModel;
    }

    /**
     * Get User by column name search
     * @param string $sColumnName
     * @param string $sValue
     * @return int
     */
    public function getTasksCount(string $sColumnName, string $sValue)
    {
        return $this->oModel->where($sColumnName, $sValue)->count();
    }
}
