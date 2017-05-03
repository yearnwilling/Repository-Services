# Repository-Services

这个packagist主要是为laravel服务的。
使用方法可以参照我自己写的开源demo

    https://github.com/yearnwilling/community

###使用方法：

#####Repository

```Repository

    //对应需要访问的model
    protected $modelName = 'App\\Models\\User';
    
    public function model()
    {
        return $this->modelName;
    }
    
```

#####Service

```Service
     /**
      * @param $RepositoryName string Repository名称
      * @param $Repository class Repository类对象
      */
     public function getRepository($RepositoryName, $Repository) {
         $this->registerRepository($RepositoryName, $Repository);
         return $this->repositories[$RepositoryName];
     }
     
     /**
       * @param $RepositoryName string Repository名称
       * @param $Repository class Repository类对象
       */
      public function getService($serviceName, $service) {
         $this->registerService($serviceName, $service);
         return $this->services[$serviceName];
     }
     
```

#####Controller.php
```Controller
    use Repository_services\Rsc\Service\Service;

    ...
    
    protected $baseServices;
    
    protected $resourcesNames = array(
        'UserService' => 'App\Services\User\UserServices',
    );
    
    public function __construct(Service $baseServices)
    {
        $this->baseServices =  $baseServices;
    }
    
    public function getService($serviceName) {
        $this->bootService($serviceName);
        return $this->baseServices->services[$serviceName];
    }

    protected function bootService($serviceName) {
        if (empty($this->resourcesNames[$serviceName])) {
            throw new \Exception("the $serviceName is not register in resourcesNames");
        }
        $this->baseServices->registerService($serviceName, $this->resourcesNames[$serviceName]);
    }
    
```