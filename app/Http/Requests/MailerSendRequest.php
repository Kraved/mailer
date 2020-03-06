<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailerSendRequest extends FormRequest
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
            'subject' => 'required|string|min:5|max:40',
            'message' => 'required|string|min:5|max:2000',
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
            'message.required' => 'Введите текст письма',
            'message.string' => 'Сообщение должно содержать строку',
            'message.min' => 'Минимальная длинна сообщения 5 символов',
            'message.max' => 'Максимальная длинна сообщения 2000 символов',
            'file.uploaded' => 'Максимальный размер прикрепленного файла 2Мб',
        ];
    }
}
