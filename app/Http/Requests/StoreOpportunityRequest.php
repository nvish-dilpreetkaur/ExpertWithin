<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\Rule;


class StoreOpportunityRequest extends FormRequest
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
            'start_date' =>  'required|date|date_format:Y-m-d H:i:s|before_or_equal:end_date|after_or_equal:today',
            'end_date' =>  'required|date|date_format:Y-m-d H:i:s|after_or_equal:start_date',
            'apply_before' =>  'required|date|date_format:Y-m-d H:i:s|before_or_equal:start_date|after_or_equal:today',
            'odesc' =>  'required',
            'incentives' =>  'required',
            'rewards' =>  'required',
            'tokens' =>  'required',
            'oexperts' => 'required|numeric|min:0|not_in:0',
            'oexperts_hrs' => 'required|numeric|min:0|not_in:0',

            'skills' =>  'required',
            'focus_area' =>  'required'
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
            'start_date.required' => "This field is required.",
            'start_date.before_or_equal' => "Start date must be a date before or equal to end date.",
            'start_date.after_or_equal' => "Start date must be a date after or equal to today.",
			'end_date.required' => "This field is required.",
            'end_date.after_or_equal' => "End date must be a date after or equal to start date.",
			'apply_before.required' => "This field is required.",
            'apply_before.before_or_equal' => "Apply Before must be a date before or equal to start date.",
            'apply_before.after_or_equal' => "Apply Before must be a date after or equal to today.",
			'odesc.required' => "This field is required.",
			'incentives.required' => "This field is required.",
			'rewards.required' => "This field is required.",
			'tokens.required' => "This field is required.",
			'oexperts.required' => "This field is required.",
			'oexperts.numeric' => "Please enter a value greater than 0",
			'oexperts.min' => "Please enter a value greater than 0",
			'oexperts.not_in' => "Please enter a value greater than 0",
			'oexperts_hrs.required' => "This field is required.",
			'oexperts_hrs.numeric' => "Please enter a value greater than 0",
			'oexperts_hrs.min' => "Please enter a value greater than 0",
			'oexperts_hrs.not_in' => "Please enter a value greater than 0",
			'skills.required' => "This field is required.",
			'focus_area.required' => "This field is required.",
        ];
    }


}
