<?php


namespace app\components;


use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use shop\repositories\doctrine\types\Card\IdType;
use shop\repositories\doctrine\types\Card\StatusType;

class EMFactory
{
    private static $instance;

    /**
     * @return EMFactory
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct(){
        $this->config['globalPath'] = $this->globalPath;
        $this->config['proxyPath'] = $this->globalPath . '/console/proxies';
        $this->config['proxyNamespace'] = 'console\proxies';
        $this->config['doctrineCachePath'] = $this->globalPath . '/doctrine/cache';
        $this->config['doctrineMappingPath'] = $this->globalPath . '/shop/repositories/doctrine/mapping';
        $this->config['entityNamespace'] = 'shop\entities';
        $this->config['dbConnection'] = include $this->globalPath . '/migrations-db.php';
        $this->config['ENV_PROD'] = false;
    }

    private function __clone(){}

    private function __wakeup(){}

    private $globalPath = __DIR__ . '/..';

    private $entityManager = NULL;

    private $entityManagerTest = null;

    private $config = [];

    public function get($key){
        if(array_key_exists($key, $this->config)){
            return $this->config[$key];
        }

        throw new \InvalidArgumentException('Config parameter "' . $key . '" not found!');
    }

    public function getTestEntityManager(){
        if($this->entityManagerTest === NULL){
            $this->config['dbConnection'] = include $this->globalPath . '/test-migrations-db.php';
            $this->entityManagerTest = $this->buildEM();
        }

        return $this->entityManagerTest;
    }

    public function getEntityManager(){
        if($this->entityManager === NULL){
            $this->config['dbConnection'] = include $this->globalPath . '/migrations-db.php';
            $this->entityManager = $this->buildEM();
        }

        return $this->entityManager;
    }

    private function buildEM(){
        return EntityManagerBuilder::getInstance()
            ->withProxyDir( $this->get('proxyPath'), $this->get('proxyNamespace'), !$this->get('ENV_PROD'))
            ->withCache(!$this->get('ENV_PROD') ? new ArrayCache() : new FilesystemCache($this->get('doctrineCachePath')))
            ->withMapping(new SimplifiedYamlDriver([ $this->get('doctrineMappingPath') => $this->get('entityNamespace') ]))
//            ->withSubscribers([ new CardSubscriber(new Hydrator()), ])
            ->withTypes([
                IdType::NAME => IdType::class,
                StatusType::NAME => StatusType::class,
            ])
            ->build($this->get('dbConnection'));
    }


}