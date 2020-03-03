<?php


namespace App\Repository;


use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository
{

    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->model = $this->setModel();
    }

    /**
     * Задает модель для репозитория
     * @return mixed
     */
    abstract function setModel();

}
