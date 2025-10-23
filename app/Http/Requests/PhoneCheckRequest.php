<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneCheckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|min:5|max:20'
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Пожалуйста, введите номер телефона',
            'phone.min' => 'Номер телефона слишком короткий',
            'phone.max' => 'Номер телефона слишком длинный'
        ];
    }
}
