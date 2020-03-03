<?php


namespace App\Repository;


use App\Models\MailList;

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


}
