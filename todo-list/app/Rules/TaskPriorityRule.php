<?php

namespace App\Rules;

use App\Models\ModelTaskPriority;
use App\Repository\Interfaces\TaskPriorityRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class TaskPriorityRule implements Rule
{
    /**
     * @var TaskPriorityRepositoryInterface
     */
    private $repositoryTaskPriority;

    public function __construct(TaskPriorityRepositoryInterface $repositoryTaskPriority)
    {
        $this->repositoryTaskPriority = $repositoryTaskPriority;
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
            return $this->repositoryTaskPriority->getById($value) !== null;
        }

        return in_array(ucfirst(strtolower($value)), ['Urgent', 'High', 'Normal', 'Low']);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Task priority must either be Urgent, High, Normal, or Low';
    }
}
