<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('users', 'username'),
            ],
            'phone_number' => [
                'required',
                'string',
                'min:10',
                'max:20',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('users', 'phone_number'),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username is required',
            'username.min' => 'Username must be at least 3 characters',
            'username.unique' => 'This username is already taken',
            'phone_number.required' => 'Phone number is required',
            'phone_number.regex' => 'Please enter a valid phone number',
            'phone_number.unique' => 'This phone number is already registered',
        ];
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone_number' => preg_replace('/[^0-9+]/', '', $this->phone_number),
        ]);
    }
}
