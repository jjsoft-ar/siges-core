<?php

namespace JJSoft\SigesCore\Http\Requests;

use Joselfonseca\LaravelApiTools\Http\Requests\ApiRequest;

/**
 * Edit a Field Request
 * Class EditFieldRequest
 * @package JJSoft\SigesCore\Http\Requests
 */
class EditFieldRequest extends ApiRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'type' => 'required',
            'description' => 'required'
        ];
    }
}
