<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ProfileRequest extends FormRequest
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
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
		$action = $request->post('action');
		switch($action) {
			case 'activity':
				return [
					'activity'   =>  'required'
				];
			break;
			case 'certificate':
				return [
					'certificate'   =>  'required'
				];
			break;
			case 'profile':
				return [
					'uname'   =>  'required',
					'designation' =>  'required',
					'dept' =>  'required',
					'manager' =>  'required',
					'about' =>  'required',
					'aspirations' =>  'required',
					'availability' =>  'required'
				];
			break;
			case 3:
				return [
					'focus'   =>  'required'
				];
			break;
			case '1':
				return [
					'skills'   =>  'required'
				];
			break;
		}
        
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'uname.required' => "This field is required.",
			'designation.required' => "This field is required.",
			'dept.required'  => "This field is required.",
			'manager.required' => "This field is required.",
			'about.required' => "This field is required.",
			'aspirations.required' => "This field is required.",
			'availability.required' => "This field is required.",
			'activity.required' => "This field is required.",
			'certificate.required' => "This field is required.",
			'skills.required' => "This field is required.",
			'focus.required' => "This field is required."
        ];
    }



}
