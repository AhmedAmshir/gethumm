<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Handlers\ResponseHandler;

class CreateIngredientRequest extends FormRequest {

    use ResponseHandler;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'supplier' => 'required|max:255',
            'measure' => 'required|max:10',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException($this->BadRequest($validator->errors()), 400);
    }

}
