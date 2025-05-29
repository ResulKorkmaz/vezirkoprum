<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'exists:users,id'],
            'body' => ['required', 'string', 'max:1000'],
        ];
    }
}
