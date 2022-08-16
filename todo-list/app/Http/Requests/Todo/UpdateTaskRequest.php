<?php

namespace App\Http\Requests\Todo;

use App\Constants\ResponseConstants;
use App\Libraries\ResponseLibrary;
use App\Models\ModelTaskPriority;
use App\Repository\TaskPriorityRepository;
use App\Rules\TaskPriorityRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateTaskRequest extends FormRequest
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
     * Run before start of validation
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['task_id' => $this->route('task_id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_id'           => ['required', 'integer'],
            'title'             => ['sometimes', 'max:255'],
            'description'       => ['sometimes'],
            'due_date'          => ['sometimes', 'date_format:"Y-m-d', 'after_or_equal:' . date('Y-m-d')],
            'priority'          => ['sometimes', new TaskPriorityRule(new TaskPriorityRepository(new ModelTaskPriority))]
        ];
    }

    /**
     * Execute when validation fails
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = ResponseLibrary::errorResponse('Please provide a Valid Task ID', ResponseConstants::INVALID_PARAMETER_REQUEST);
        throw new ValidationException($validator, $response);
    }
}
