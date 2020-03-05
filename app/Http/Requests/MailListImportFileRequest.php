<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class MailListImportFileRequest extends FormRequest
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
            'importfile' => 'required|mimetypes:text/plain',
        ];
    }

    public function messages()
    {
        return [
            'importfile.required' => 'Загрузите файл!',
            'importfile.mimetypes' => 'Неверный формат файла!',
        ];
    }


}
