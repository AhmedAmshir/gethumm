<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Handlers\ResponseHandler;

class CreateBoxOrderRequest extends FormRequest
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
    public function rules() {

        $available_after_two_days = date('Y-m-d', strtotime(date('Y-m-d H:i:s') . " +48 hours"));
        return [
            'fullname' => 'required|max:255',
            'address' => 'required|max:255',
            'mobile' => 'required|min:8|max:16',
            'delivery_date' => 'required|after:'.$available_after_two_days,
        ];
    }

    public function messages() {
        return [
            'delivery_date.after' => 'The delivery order will be available after the next 48 hours',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException($this->BadRequest($validator->errors()), 400);
    }
}
