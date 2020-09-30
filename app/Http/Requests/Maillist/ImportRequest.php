<?php

namespace App\Http\Requests\Maillist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ImportRequest extends FormRequest
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
            'importfile' => 'mimetypes:text/plain',
            'site' => 'string|max:500|min:10'
        ];
    }

    public function messages()
    {
        return [
            'importfile.required' => 'Загрузите файл!',
            'importfile.mimetypes' => 'Неверный формат файла!',
            'site.string' => 'Поле должно содержать строку!',
            'site.max' => 'Максимальная длинна [:max] символов',
            'site.min' => 'Минимальная длинна [:min] символов',
        ];
    }


}
