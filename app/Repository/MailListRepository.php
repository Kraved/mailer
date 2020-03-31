<?php


namespace App\Repository;


use App\Models\MailList;
use Illuminate\Support\Collection;

class MailListRepository extends CoreRepository
{

    /**
     * @return MailList
     */
    function setModel()
    {
        return new MailList;
    }

    /**
     * Возвращает данные в пагинаторе
     * @param int $count
     * @return mixed
     */
    public function getAllWithPaginate(int $count)
    {
        $paginator = $this->model->paginate($count);
        return $paginator;
    }

    /**
     * Получение списка почтовых адресов для дальнешего экспорта
     *
     * @return Collection
     */
    public function getMailToExport():Collection
    {
        $data = $this->model->select('email')->get();
        $mails = $data->map(function ($item) {
            return $item->email;
        });
        return $mails;
    }
}
