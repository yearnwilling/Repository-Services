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
    }

//    protected function makeRepository()
//    {
//        $repositories_container = $this->repositories();
//
//        foreach ($repositories_container as $key => $repository) {
//            $this->injectionRepository($key, $repository);
//        }
//
//        return $this->repositories;
//    }

    protected function injectionRepository($key, $repository) {
        if (!isset($this->repositories[$key])) {
            $repository = $this->container->make($repository);

            if (!$repository instanceof Repository) {
                throw new \Exception("Class {$this->repositories()} must be an instance of Repository_services\\Rsc\\Repository\\Repository");
            }

            $this->repositories[$key] = $repository;
        }
    }

    protected function registerRepository($repositoryName, $repository) {
        if (empty($this->repositories[$repositoryName])) {
            throw new \Exception("the $repositoryName is not register in repositoriesNames function");
        }
        $this->injectionRepository($repositoryName, $repository);
    }
}