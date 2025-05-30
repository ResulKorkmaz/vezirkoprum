<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhatsappGroupRequest extends FormRequest
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
        $cities = array_keys(config('turkiye.cities', []));
        
        return [
            'city' => ['required', 'string', 'in:' . implode(',', $cities)],
            'district' => ['nullable', 'string', 'max:64'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'invite_link' => ['required', 'url', 'max:255', 'regex:/^https:\/\/chat\.whatsapp\.com\/.+/'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'city.required' => 'Şehir seçimi zorunludur.',
            'city.in' => 'Geçersiz şehir seçimi.',
            'name.required' => 'Grup adı zorunludur.',
            'name.max' => 'Grup adı en fazla 255 karakter olabilir.',
            'description.max' => 'Açıklama en fazla 1000 karakter olabilir.',
            'invite_link.required' => 'WhatsApp davet linki zorunludur.',
            'invite_link.url' => 'Geçerli bir URL giriniz.',
            'invite_link.regex' => 'Geçerli bir WhatsApp davet linki giriniz (https://chat.whatsapp.com/... formatında).',
        ];
    }
}
