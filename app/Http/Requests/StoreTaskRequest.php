<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:8', 'max:255'],
            'duration' => ['required', 'date'],
            'status' => ['required', 'string', 'min:8', 'max:255'],
            'description' => ['required', 'string'],
            'project_id' => ['required', 'integer'],
            'team_member_id' => ['required', 'integer'],
        ];
    }
}
