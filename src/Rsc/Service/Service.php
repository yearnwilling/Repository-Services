<?php
/**
 * Created by PhpStorm.
 * User: yearnwilling
 * Date: 2017/4/24
 * Time: 上午9:24
 */

namespace Repository_services\Rsc\Service;

use Illuminate\Container\Container;
use Repository_services\Rsc\Repository\Repository;


abstract class Service
{
    protected $container;

    protected $repositories;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->makeRepository();
    }

    abstract function repositories();

    protected function makeRepository()
    {
        $repositories_container = $this->repositories();

        foreach ($repositories_container as $key => $repository) {
            $repository = $this->container->make($repository);

            if (!$repository instanceof Repository) {
                throw new \Exception("Class {$this->repositories()} must be an instance of Repository_services\\Rsc\\Repository\\Repository");
            }

            $this->repositories[$key] = $repository;

        }

        return $this->repositories;

    }
}