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

abstract class Repository
{
    protected $container;

    protected $model;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->makeModel();
    }

    /**
     * 需要加载的model
     * @return mixed
     */
    abstract function model();

    public function makeModel() {
        $model = $this->container->make($this->model());

        if (!$model instanceof Model)
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    public function wheres($builder, $conditions)
    {
        foreach ($conditions as $key => $condition) {
            $cuttings = explode(' ', trim($condition), 2);
            $builder->where($key , $conditions[0], $conditions[1]);
        }
        return $builder;
    }
}