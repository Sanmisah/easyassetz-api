<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBeneficiaryRequest extends FormRequest
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
            'profile_id' => 'required|exists:profiles,id',
            'full_legal_name' => 'sometimes|string|max:255',
            'relationship' => 'sometimes|string|max:255',
            'gender' => 'sometimes|string',
            'dob' => 'sometimes|string',
            'guardian_full_legal_name' => 'sometimes|string|max:255',
            'guardian_mobile_number' => 'sometimes|string|max:20',
            'guardian_email' => 'nullable|email|max:255',
            'guardian_city' => 'sometimes|string|max:255',
            'guardian_state' => 'sometimes|string|max:255',
            'adhar_number' => 'nullable|string|max:12',
            'pan_number' => 'nullable|string|max:10',
            'passport_number' => 'nullable|string|max:15',
            'driving_licence_number' => 'nullable|string|max:20',
            'religion' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'house_flat_no' => 'sometimes|string|max:255',
            'address_line_1' => 'sometimes|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'pincode' => 'sometimes|string|max:10',
            'beneficiary_city' => 'sometimes|string|max:255',
            'beneficiary_state' => 'nullable|string|max:255',
            'beneficiary_country' => 'nullable|string|max:255',
            'charity_name' => 'sometimes|string|max:255',
            'charity_address_1' => 'nullable|string|max:65535',
            'charity_address_2' => 'nullable|string|max:65535',
            'charity_city' => 'sometimes|string|max:255',
            'charity_state' => 'nullable|string|max:255',
            'charity_phone_number' => 'sometimes|string|max:20',
            'charity_email' => 'nullable|email|max:255',
            'charity_contact_person' => 'sometimes|string|max:255',
            'charity_website' => 'nullable|string|max:255',
            'charity_specific_instruction' => 'nullable|string|max:300'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(['success'=>false, 'message' => $errors], 422));
    }

}
