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
            'user_id' => 'required|exists:users,id',
            'full_legal_name' => 'required|string|max:255',
            'gender' => 'required',
            'dob' => 'required',
            'nationality' => 'required|string',
            'country_of_residence' => 'required|string',
            'religion' => 'required|string',
            'marital_status' => 'nullable|string',
            'married_under_special_act' => 'required|string',
            'correspondence_email' => 'required|string|email|max:255|unique:profiles',
            'permanent_house_flat_no' => 'required|string|max:255',
            'permanent_address_line_1' => 'required|string|max:255',
            'permanent_address_line_2' => 'nullable|string|max:255',
            'permanent_pincode' => 'required|string|max:10',
            'permanent_city' => 'required|string|max:255',
            'permanent_state' => 'nullable|string|max:255',
            'permanent_country' => 'nullable|string|max:255',
            'current_house_flat_no' => 'required|string|max:255',
            'current_address_line_1' => 'required|string|max:255',
            'current_address_line_2' => 'nullable|string|max:255',
            'current_pincode' => 'required|string|max:10',
            'current_city' => 'required|string|max:255',
            'current_state' => 'nullable|string|max:255',
            'current_country' => 'nullable|string|max:255',
            'adhar_number' => 'sometimes|string|max:12',
            'adhar_name' => 'nullable|string|max:255',
            'adhar_file' => 'nullable|max:2048',
            'pan_number' => 'sometimes|string|max:10',
            'pan_name' => 'nullable|string|max:255',
            'pan_file' => 'sometimes|file|max:2048',
            'passport_number' => 'nullable|string|max:15',
            'passport_name' => 'nullable|string|max:255',
            'passport_expiry_date' => 'nullable|string',
            'passport_place_of_issue' => 'nullable|string|max:255',
            'passport_file' => 'nullable|file|max:2048',
            'driving_licence_number' => 'nullable|string|max:20',
            'driving_licence_name' => 'nullable|string|max:255',
            'driving_licence_expiry_date' => 'nullable|string',
            'driving_licence_place_of_issue' => 'nullable|string|max:255',
            'driving_licence_file' => 'nullable|file|max:2048',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(['success'=>false, 'message' => $errors], 422));
    }

}
