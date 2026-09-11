<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdditionalSymptomsRequest extends FormRequest
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
            'name'       => 'required|string|max:255',
            'age'        => 'required|integer|min:1|max:120',
            'sex'        => 'required|in:male,female',
            'bodytemp'   => 'required|numeric|min:98.1|max:104.0',
            'symptoms'   => 'required|array|min:1',
            'asymptoms'  => 'required|array|min:1',
        ];
    }
}
