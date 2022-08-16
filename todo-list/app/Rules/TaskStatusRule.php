<?php

namespace App\Rules;

use App\Repository\Interfaces\TaskStatusRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class TaskStatusRule implements Rule
{
    /**
     * @var TaskStatusRepositoryInterface
     */
    private $repositoryTaskStatus;

    public function __construct(TaskStatusRepositoryInterface $repositoryTaskStatus)
    {
        $this->repositoryTaskStatus = $repositoryTaskStatus;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_numeric($value) === true) {
            return $this->repositoryTaskStatus->getById($value) !== null;
        }

        return in_array(ucfirst(strtolower($value)), ['Todo', 'Completed']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Task priority must either be Todo or Completed';
    }
}
