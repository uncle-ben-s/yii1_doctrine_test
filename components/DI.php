<?php


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class DI extends \CApplicationComponent
{
    public $_container;
    public function getContainer()
    {
        if (!$this->_container) {
            $this->_container = new ContainerBuilder();
            $loader = new YamlFileLoader($this->_container, new FileLocator(__DIR__ . '/../config/'));
            $loader->load('services.yaml');
            $this->_container->compile();
        }
        return $this->_container;
    }
}