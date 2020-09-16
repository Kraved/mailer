<?php


namespace App\Services\Maillist\Import;


use App\Models\MailList;
use Illuminate\Database\Eloquent\Model;

abstract class BaseImport
{

    /**
     * Проверка массива ссылок на соответствие RegEx патерну почтовых адресов
     * @param array $data
     * @return array|bool
     */
    public function checkWithRegExp(array $data)
    {
        $pattern = "/^[A-Za-z0-9][A-Za-z0-9\.\-_]*[A-Za-z0-9]*@([A-Za-z0-9]+([A-Za-z0-9-]*[A-Za-z0-9]+)*\.)+[A-Za-z]*$/";
        $mails = preg_grep($pattern, $data);
        if (empty($mails)) {
            return false;
        }else{
            return $mails;
        }
    }

    /**
     * Принимает список проверенных почтовых адресов, и сохраняет их в таблицу почт. адресов.
     * Возвращает результат сохранения.
     * Если почта присутствует в таблице, возвращает сообщение.
     * @param array $mails
     * @return bool
     */
    public function saveCheckedData(array $mails): bool
    {
        /** @var Model $model */
        $model = app(MailList::class);
        foreach ($mails as $mail) {
            if(! $model->firstOrCreate(['email' => $mail])){
                info("Не удалось добавить в базу {$mail}");
                return false;
            }
        }
        return true;
    }

}