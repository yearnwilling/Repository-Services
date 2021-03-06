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
            $builder->where($key , $cuttings[0], $cuttings[1]);
        }
        return $builder;
    }

    public function create($model_fields)
    {
        return $this->model->create($model_fields);
    }

    /**
     * update modal date
     * @param $id integer needed update data Primary Key
     * @param $model_fields
     * @return mixed
     */
    public function update($id, $model_fields)
    {
        return $this->model->findOrFail($id)->update($model_fields);
    }

    /**
     * get all date
     * @param array $preload Relationships modal's name
     * @return mixed
     */
    public function getAll($preload = array())
    {
        return $this->model->with($preload)->get();
    }

    /**
     * search date
     * @param int $pageNumber one page list number
     * @param array $preload  Relationships modal's name
     * @return mixed
     */
    public function search($pageNumber = 10, $preload = array())
    {
        return $this->model->with($preload)->paginate($pageNumber);
    }

    /**
     * get a line data
     * @param $id integer the Primary Key of modal
     * @param array $preload Relationships modal's name
     * @return mixed
     */
    public function get($id, $preload = array())
    {
        return $this->model->with($preload)->findOrFail($id);
    }
}