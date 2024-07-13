<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProfileRequest extends FormRequest
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
             'fullLegalName'=>['required','string'],
             'aadharFile' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
             'panFile' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
             'passportFile' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
             'drivingFile' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(['success'=>false, 'message' => $errors], 422));
    }

}
