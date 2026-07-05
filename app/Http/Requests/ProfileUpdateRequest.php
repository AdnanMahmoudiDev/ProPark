<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],

            'email' => [
                'sometimes',
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'phone_number' => [
                'sometimes',
                'required',
                'string',
                'min:11',
                'max:11',
                'regex:/^09[0-9]{9}$/',
            ],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'phone_number.required' => 'وارد کردن شماره تلفن الزامی است.',
            'phone_number.min' => 'شماره تلفن کمتر از 11 عدد است.',
            'phone_number.max' => 'شماره تلفن بیشتر از 11 عدد است.',
            'phone_number.regex' => 'شماره تلفن باید با 09 شروع شود.',
        ];
    }
}
