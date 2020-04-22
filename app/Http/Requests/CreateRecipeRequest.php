<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Handlers\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRecipeRequest extends FormRequest
{
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
            'description' => 'required',
            'ingredients.*.id' => 'required',
            'ingredients.*.amount' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException($this->BadRequest($validator->errors()), 400);
    }
}
