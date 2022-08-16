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

class CreateTaskRequest extends FormRequest
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
            'title'             => ['required', 'max:255'],
            'description'       => ['required'],
            'due_date'          => ['sometimes', 'date_format:"Y-m-d', 'after_or_equal:' . date('Y-m-d')],
            'priority'          => ['nullable', new TaskPriorityRule(new TaskPriorityRepository(new ModelTaskPriority))]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'due_date.date_format' => 'The due date does not match the format YYYY-MM-DD'
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
