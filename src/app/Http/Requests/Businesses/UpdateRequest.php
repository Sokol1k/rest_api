<?php

namespace App\Http\Requests\Businesses;

use App\Models\Business;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->business);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'url' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'category' => ['nullable', 'string', 'max:50'],
            'rating' => ['nullable'],
            'rating_buildzoom' => ['nullable'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'string', 'max:255'],
            'is_licensed' => ['nullable'],
            'license_info' => ['nullable'],
            'insured_value' => ['nullable', 'string', 'max:50'],
            'bond_value' => ['nullable', 'string', 'max:50'],
            'street_address' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:50'],
            'state' => ['nullable', 'string', 'max:10'],
            'zipcode' => ['nullable', 'string', 'max:20'],
            'full_address' => ['nullable', 'string', 'max:130'],
            // 'image' => ['nullable', 'image:jpeg,jpg,png', 'max:10000'],
            'employee' => ['nullable'],
            'work_preferences' => ['nullable'],
        ];
    }
}
