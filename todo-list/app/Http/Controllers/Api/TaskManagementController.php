<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Libraries\ConstantLibrary;
use App\Libraries\ResponseLibrary;
use App\Repository\Interfaces\TaskPriorityRepositoryInterface;
use App\Repository\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class TaskManagementController extends Controller
{

    protected $JWTAuth;

    /**
     * @var TaskPriorityRepositoryInterface
     */
    private $repositoryTaskPriority;

    /**
     * @var TaskRepositoryInterface
     */
    private $repositoryTask;

    public function __construct(TaskRepositoryInterface $repositoryTask, TaskPriorityRepositoryInterface $repositoryTaskPriority, JWTAuth $JWTAuth)
    {
        $this->JWTAuth = $JWTAuth;
        $this->repositoryTask = $repositoryTask;
        $this->repositoryTaskPriority = $repositoryTaskPriority;
    }

    public function createTask(CreateTaskRequest $request)
    {
        $requestValidated = $request->validated();
        $requestToken = $this->JWTAuth->getToken();
        $authUser = $this->JWTAuth->toUser($requestToken);

        if (isset($requestValidated['priority']) === false || is_numeric($requestValidated['priority']) === true) {
            $requestPriorityId = $requestValidated['priority'] ?? 5;
        } else {
            $selectedPriority = ucfirst(strtolower($requestValidated['priority']));
            $requestPriorityId = $this->repositoryTaskPriority
                ->getPriorityByColumnName('priority_name', $selectedPriority)
                ->first()
                ->id;
        }
        $totalUserCreatedTasks = $this->repositoryTask->getTasksCount('user_id', $authUser->id);
        $requestTaskOrder = ($totalUserCreatedTasks > 0) ? ($totalUserCreatedTasks + 1) : 1;

        $aCreateTaskParameter = array(
            'user_id'               => $authUser->id,
            'task_status_id'        => ConstantLibrary::TASK_STATUS_TODO,
            'task_priority_id'      => $requestPriorityId,
            'task_title'            => $requestValidated['title'],
            'task_description'      => $requestValidated['description'],
            'task_order'            => $requestTaskOrder,
        );

        if (isset($requestValidated['due_date']) === true) {
            $aCreateTaskParameter['due_date'] = $requestValidated['due_date'];
        }

        return ResponseLibrary::successDataResponse([
            'task'  => new TaskResource($this->repositoryTask->create($aCreateTaskParameter))
        ]);
    }
    public function updateTask() {}
    public function getTaskList() {}
    public function getTaskDetail() {

    }
    public function deleteTask() {}
}
