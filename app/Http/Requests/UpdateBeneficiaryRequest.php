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
        $dob = $this->input('dob');
        $age = Carbon::parse($dob)->age;

        return [
            'fullLegalName'=>['sometimes','string'],
            'dob' => ['required', 'date'],
            'guardianCity' => [
                $age < 18 ? 'required' : 'nullable',
                'string',
            ],
            'guardianName'=> [
                $age < 18 ? 'required' : 'nullable',
                'string',
            ],
            'guardianMobile'=>[
                $age < 18 ? 'required' : 'nullable',
                'string',
            ],
            'guardianEmail'=>[
                $age < 18 ? 'required' : 'nullable',
                'string',
            ],
            'guardianCity'=>[
                $age < 18 ? 'required' : 'nullable',
                'string',
            ],
            'guardianState'=>[
                $age < 18 ? 'required' : 'nullable',
                'string',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json(['success'=>false, 'message' => $errors], 422));
    }

}
