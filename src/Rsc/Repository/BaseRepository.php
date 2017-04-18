<?php
/**
 * Created by PhpStorm.
 * User: yearnwilling
 * Date: 2017/4/18
 * Time: 下午11:28
 */

namespace Repository_services\Rsc\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $container;

    protected $model;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->makeModel();
    }

    abstract function model();

    public function makeModel() {
        $model = $this->container->make($this->model());

        if (!$model instanceof Model)
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }
}