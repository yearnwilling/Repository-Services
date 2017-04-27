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


class Service
{
    protected $container;

    protected $repositories;

    protected $services;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function injectionRepository($key, $repository)
    {
        $repository = $this->container->make($repository);

        if (!$repository instanceof Repository) {
            throw new \Exception("Class {$this->repositories()} must be an instance of Repository_services\\Rsc\\Repository\\Repository");
        }

        $this->repositories[$key] = $repository;
    }

    protected function injectionService($key, $service)
    {
        $service = $this->container->make($service);

        if (!$service instanceof Service) {
            throw new \Exception("Class {$this->repositories()} must be an instance of Repository_services\\Rsc\\Service\\Service");
        }

        $this->services[$key] = $service;
    }

    protected function registerRepository($repositoryName, $repository)
    {
        if (!isset($this->repositories[$repositoryName])) {
            $this->injectionRepository($repositoryName, $repository);
        }
    }

    protected function registerService($serviceName, $service)
    {
        if (!isset($this->services[$serviceName])) {
            $this->injectionService($serviceName, $service);
        }
    }


}