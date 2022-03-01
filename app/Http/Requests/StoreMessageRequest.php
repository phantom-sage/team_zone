<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'message' => ['required', 'string'],
            'sender_id' => ['required', 'integer'],
            'recipient_id' => ['required', 'integer'],
            'sender_type' => ['required', 'regex:/^(User|TeamMember)$/', 'string'],
            'recipient_type' => ['required', 'regex:/^(User|TeamMember)$/', 'string'],
        ];
    }
}
