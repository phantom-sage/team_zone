<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'name' => ['string', 'required', 'unique:projects'],
            'deadline' => ['required', 'date'],
            'client_username' => ['required', 'string', 'min:3', 'max:255'],
            'client_email' => ['required', 'string', 'email', 'max:255', 'unique:App\Models\Client,email'],
            'status' => ['required', 'string'],
            'project_manager_id' => ['required', 'integer'],
        ];
    }
}
