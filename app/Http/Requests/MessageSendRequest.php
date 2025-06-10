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
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:2000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'receiver_id.required' => 'Alıcı seçilmelidir.',
            'receiver_id.exists' => 'Geçersiz alıcı.',
            'subject.required' => 'Konu alanı zorunludur.',
            'subject.max' => 'Konu en fazla 255 karakter olabilir.',
            'content.required' => 'Mesaj içeriği zorunludur.',
            'content.max' => 'Mesaj en fazla 2000 karakter olabilir.',
        ];
    }
}
