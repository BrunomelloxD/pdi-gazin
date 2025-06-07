<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\UserValidationMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
{
    use UserValidationMessages;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Erro de validação',
            'errors' => $errors
        ], 422));
    }
}
