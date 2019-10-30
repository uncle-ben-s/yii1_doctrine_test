<?php

use app\components\EMFactory;
use Doctrine\ORM\EntityManager;

class DoctrineComponent extends \CComponent
{
    private $em = null;
    
    public function init()
    {
        $this->em = EMFactory::getInstance()->getEntityManager();
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}