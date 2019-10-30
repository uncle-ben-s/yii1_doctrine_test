<?php


namespace app\components;


use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class EntityManagerBuilder
{
    private static $instance;

    /**
     * @return EntityManagerBuilder
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct(){}

    private function __clone(){}

    private function __wakeup(){}

    private $proxyNamespace;
    private $proxyDir;
    private $proxyAutoGenerate;
    private $cacheProvider;
    private $mappingDriver;
    private $subscribers = [];
    private $listeners = [];
    private $types = [];
    private $entityManager = NULL;

    public function withProxyDir($dir, $namespace, $autoGenerate)
    {
        $this->proxyDir = $dir;
        $this->proxyNamespace = $namespace;
        $this->proxyAutoGenerate = $autoGenerate;
        return $this;
    }

    public function withCache(CacheProvider $cache)
    {
        $this->cacheProvider = $cache;
        return $this;
    }

    public function withMapping(MappingDriver $driver)
    {
        $this->mappingDriver = $driver;
        return $this;
    }

    public function withSubscribers(array $subscribers)
    {
        $this->subscribers = $subscribers;
        return $this;
    }

    public function withListeners(array $listeners)
    {
        $this->listeners = $listeners;
        return $this;
    }

    public function withTypes(array $types)
    {
        $this->types = $types;
        return $this;
    }

    /**
     * @param $params
     * @return EntityManager
     * @throws \InvalidArgumentException
     * @throws ORMException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function build($params)
    {
        if($this->entityManager !== NULL){
            return $this->entityManager;
        }

        $this->checkParameters();

        $config = new Configuration();

        $config->setProxyDir($this->proxyDir);
        $config->setProxyNamespace($this->proxyNamespace);
        $config->setAutoGenerateProxyClasses($this->proxyAutoGenerate);

        $config->setMetadataDriverImpl($this->mappingDriver);

        if (!$this->cacheProvider) {
            $config->setMetadataCacheImpl($this->cacheProvider);
            $config->setQueryCacheImpl($this->cacheProvider);
        }

        $evm = new EventManager();

        foreach ($this->subscribers as $subscriber) {
            $evm->addEventSubscriber($subscriber);
        }

        foreach ($this->listeners as $name => $listener) {
            $evm->addEventListener($name, $listener);
        }

        foreach ($this->types as $name => $type) {
            if (Type::hasType($name)) {
                Type::overrideType($name, $type);
            } else {
                Type::addType($name, $type);
            }
        }

        $this->entityManager = EntityManager::create($params, $config, $evm);

        return $this->entityManager;
    }

    private function checkParameters()
    {
        if (empty($this->proxyDir) || empty($this->proxyNamespace)) {
            throw new \InvalidArgumentException('Specify proxy settings.');
        }

        if (!$this->mappingDriver) {
            throw new \InvalidArgumentException('Specify mapping driver.');
        }
    }
}