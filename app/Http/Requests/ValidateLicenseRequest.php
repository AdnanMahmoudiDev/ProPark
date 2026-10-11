<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateLicenseRequest extends FormRequest
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
        $demoKey = env('PROPARK_DEMO_LICENSE_KEY', env('DEMO_TRIAL_LICENSE_KEY', 'PROPARK-DEMO-TRIAL'));

        return [
            'license_key' => [
                'required',
                'string',
                Rule::when(
                    $this->input('license_key') !== $demoKey,
                    ['exists:licenses,license_key']
                ),
            ],
            'machine_fingerprint' => ['required', 'string', 'max:255'],
        ];
    }
}
