<?php

namespace App\Http\Controllers\Api;

use App\Constants\ResponseConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\CreateTaskRequest;
use App\Http\Requests\Todo\GetTaskListRequest;
use App\Http\Requests\Todo\GetTaskRequest;
use App\Http\Requests\Todo\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Libraries\ConstantLibrary;
use App\Libraries\ResponseLibrary;
use App\Models\ModelTask;
use App\Repository\Interfaces\TaskPriorityRepositoryInterface;
use App\Repository\Interfaces\TaskRepositoryInterface;
use App\Repository\Interfaces\TaskStatusRepositoryInterface;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class TaskManagementController extends Controller
{
    /**
     * @var JWTAuth
     */
    protected $JWTAuth;

    /**
     * @var TaskPriorityRepositoryInterface
     */
    private $repositoryTaskPriority;

    /**
     * @var TaskStatusRepositoryInterface
     */
    private $repositoryTaskStatus;

    /**
     * @var TaskRepositoryInterface
     */
    private $repositoryTask;

    public function __construct(TaskRepositoryInterface $repositoryTask, TaskStatusRepositoryInterface $repositoryTaskStatus, TaskPriorityRepositoryInterface $repositoryTaskPriority, JWTAuth $JWTAuth)
    {
        $this->JWTAuth = $JWTAuth;
        $this->repositoryTask = $repositoryTask;
        $this->repositoryTaskStatus = $repositoryTaskStatus;
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

    public function updateTask(UpdateTaskRequest $request)
    {
        $requestValidated = $request->validated();
        unset($requestValidated['task_id']);

        //Get the priority ID if text
        if ($request->has('priority') === true && is_numeric($request->priority) === false) {
            $selectedPriority = ucfirst(strtolower($request->priority));
            $requestValidated['priority'] = $this->repositoryTaskPriority
                ->getPriorityByColumnName('priority_name', $selectedPriority)
                ->first()
                ->id;
        }

        //Get the status ID if text
        if ($request->has('status') === true && is_numeric($request->status) === false) {
            $selectedPriority = ucfirst(strtolower($request->status));
            $requestValidated['status'] = $this->repositoryTaskStatus
                ->getStatusByColumnName('status_name', $selectedPriority)
                ->first()
                ->id;
        }

        $requestValidated = $this->getMappedParam($requestValidated, self::UPDATE_TASK);
        $aTaskDetail = $this->repositoryTask->getTaskById($request->task_id);
        $aTaskDetail->update($requestValidated);

        return ResponseLibrary::successDataResponse([
            'task'  => new TaskResource($this->repositoryTask->getTaskById($request->task_id))
        ]);
    }


    public function getTaskList(GetTaskListRequest $request)
    {
        $aSearchParameter = $this->retrieveTaskList($request);
        if ($aSearchParameter->count() > 0) {
            return ResponseLibrary::successDataResponse([
                'count'  => $aSearchParameter->count(),
                'tasks'  => TaskResource::collection($aSearchParameter->get()),
            ]);
        }

        return ResponseLibrary::noDataResponse('No Task Found');
    }

    /**
     * @param GetTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaskDetail(GetTaskRequest $request)
    {
        $aTaskDetail = $this->repositoryTask->getTaskById((int)$request->task_id);
        if ($aTaskDetail === null) {
            return ResponseLibrary::errorResponse('Task not found', ResponseConstants::NOT_FOUND);
        }
        return ResponseLibrary::successDataResponse([
            'task'  => new TaskResource($aTaskDetail)
        ]);
    }

    public function deleteTask(GetTaskRequest $request)
    {
        $aTaskDetail = $this->repositoryTask->getTaskById($request->task_id);
        if ($aTaskDetail === null) {
            return ResponseLibrary::errorResponse('Task not found', ResponseConstants::NOT_FOUND);
        }
        $aTaskDetail->delete();
        return ResponseLibrary::successResponse('Task deleted', ResponseConstants::OK_REQUEST);
    }

    /**
     * Retrieve task list from model
     * @param Request $request
     * @return mixed
     */
    private function retrieveTaskList(Request $request)
    {
        $taskList = $this->repositoryTask->query();
        if ($request->has('title') === true) {
            $aSearchText = array_filter(array_map('trim', explode(' ', $request->title)));
            if (empty($aSearchText) === false) {
                foreach ($aSearchText as $sSearchText) {
                    $taskList = $taskList->where('task_title', 'like', '%' . $sSearchText . '%');
                }
            }
        }

        if ($request->has('priority') === true) {
            if (is_numeric($request->priority) === true) {
                $taskPriorityId = (int) $request->priority;
            } else {
                $selectedPriority = ucfirst(strtolower($request->priority));
                $taskPriorityId = $this->repositoryTaskPriority
                    ->getPriorityByColumnName('priority_name', $selectedPriority)
                    ->first()
                    ->id;
            }

            $taskList = $taskList->where('task_priority_id', $taskPriorityId);
        }

        if ($request->has('status') === true) {
            if (is_numeric($request->status) === true) {
                $taskStatusId = (int) $request->status;
            } else {
                $selectedPriority = ucfirst(strtolower($request->status));
                $taskStatusId = $this->repositoryTaskStatus
                    ->getStatusByColumnName('status_name', $selectedPriority)
                    ->first()
                    ->id;
            }

            $taskList = $taskList->where('task_status_id', $taskStatusId);
        }

        return $taskList;
    }
}
