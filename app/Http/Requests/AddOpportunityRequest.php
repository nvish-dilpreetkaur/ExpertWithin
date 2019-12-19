<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\Rule;


class AddOpportunityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    protected function failedValidation(Validator $validator) {
        if ($this->ajax() || $this->wantsJson())
        {
            $errors = array("status" => false, "message" => $validator->errors());
            throw new HttpResponseException(response()->json($errors, 200));
        }
    }
    /**
     * Determine if the current request is asking for JSON in return.
     *
     * @return bool
     */
    public function wantsJson()
    {
        $acceptable = $this->getAcceptableContentTypes();
         return isset($acceptable[0]) && $acceptable[0] == 'application/json';  
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'otitle'   =>  'required',
            'odesc' =>  'required',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'otitle.required' => "This field is required.",
			'odesc.required' => "This field is required."
        ];
    }


}
