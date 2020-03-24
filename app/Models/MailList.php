<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MailList
 *
 * @property int $id
 * @property string $email
 */
class MailList extends Model
{
    use SoftDeletes;

    protected $table = 'mail_list';

    protected $guarded = [];

    /**
     * Метод ищет в таблице наличие записи по атрибутам,
     * и добавляет новую запись в случае необнаружения.
     * Отличие от findOr* методов в возвращаемом булевом значении.
     * !! Возвращает тру в случае создании записи, а не успеха поиска !!
     *
     * @param array $attributes
     * @return bool
     */
    public function customFindOrNew(array $attributes):bool
    {
        $find = $this->where($attributes)->get();
        if ($find->isNotEmpty()) {
            return false;
        } else {
            $this->create($attributes);
            return true;
        }
    }
}
