<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBusinessAssetRequest extends FormRequest
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
            'shareCentificateFile' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
            'partnershipDeedFile' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
            'jvAgreementFile' => ['nullable', 'max:2048'],
            'loanDepositeReceipt' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
            'promisoryNote' => ['nullable','file', 'mimes:jpg,png,jpeg,pdf,doc', 'max:2048'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(['success'=>false, 'message' => $errors], 422));
    }
    
}