<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MailerSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|string|min:5|max:40',
            'text' => 'required|string|min:5|max:2000',
            'file' => 'file|max:2000'
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'Введите тему письма',
            'subject.string' => 'Тема письма должна содержать строку',
            'subject.min' => 'Минимальная длинна темы письма 5 символов',
            'subject.max' => 'Максимальная длинна темы письма 40 символов',
            'text.required' => 'Введите текст письма',
            'text.string' => 'Сообщение должно содержать строку',
            'text.min' => 'Минимальная длинна сообщения 5 символов',
            'text.max' => 'Максимальная длинна сообщения 2000 символов',
            'file.uploaded' => 'Максимальный размер прикрепленного файла 2Мб',
        ];
    }
}
