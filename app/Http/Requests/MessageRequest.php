<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:191',
            'email'     => 'required|email|max:191',
            'phone'     => 'required',
            'message'   => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'حقل الإسم مطلوب',
            'email.required' => 'حقل الإيميل مطلوب',
            'phone.required' => 'حقل الهاتف مطلوب',
            'message.required' => 'حقل مضمون الرسالة مطلوب',
        ];
    }
}
