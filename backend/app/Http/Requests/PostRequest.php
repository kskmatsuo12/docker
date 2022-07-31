<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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

    public function validationData()
    {
        $texts = json_decode($this->input('texts'), true);
        return $this->all() + ['array' => $texts];
    }

    public function rules()
    {
        return [
            'texts' => 'json',
            'array.*.name' => 'required|string',
            'array.*.content' => 'required|string|max:1000'
        ];
    }
}
