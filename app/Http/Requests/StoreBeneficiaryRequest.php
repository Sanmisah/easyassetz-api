<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBeneficiaryRequest extends FormRequest
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
            'profile_id'=>['required','exists:profiles,id'],
            'fullLegalName'=>['sometimes','string','max:255'],
            'guardianFullLegalName'=>['sometimes','string'],
            'guardianNumber'=>['sometimes','phone:strict'],  //'regex:/^\+\d{1,3}\d{3,14}$/'
            'guardianEmail'=>['nullable','email:ref,dns'],
            'guardianCity'=>['sometimes','string'],
            'guardianState'=>['nullable','string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(['success'=>false, 'message' => $errors], 422));
    }
}
