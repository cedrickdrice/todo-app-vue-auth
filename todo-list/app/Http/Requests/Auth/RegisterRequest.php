<?php

namespace App\Http\Requests\Auth;

use App\Constants\ResponseConstants;
use App\Libraries\ResponseLibrary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = false;

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
            'name'      => ['required'],
            'email'     =>  ['required', 'email', 'unique:users'],
            'password'  => ['required', 'min:6'],
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
