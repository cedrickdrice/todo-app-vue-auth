<?php

namespace App\Http\Requests\Todo;

use App\Constants\ResponseConstants;
use App\Libraries\ResponseLibrary;
use App\Models\ModelTaskPriority;
use App\Models\ModelTaskStatus;
use App\Repository\TaskPriorityRepository;
use App\Repository\TaskStatusRepository;
use App\Rules\TaskPriorityRule;
use App\Rules\TaskStatusRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class GetTaskListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => ['sometimes', 'max:255'],
            'due_date'          => ['sometimes', 'date_format:"Y-m-d'],
            'priority'          => ['sometimes', new TaskPriorityRule(new TaskPriorityRepository(new ModelTaskPriority))],
            'status'          => ['sometimes', new TaskStatusRule(new TaskStatusRepository(new ModelTaskStatus))]
        ];
    }

    /**
     * Execute when validation fails
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = ResponseLibrary::errorResponse($validator->errors(), ResponseConstants::INVALID_PARAMETER_REQUEST);
        throw new ValidationException($validator, $response);
    }
}
