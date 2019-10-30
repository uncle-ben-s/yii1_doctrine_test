<?php


namespace app\components;

class EntityManagerCreator
{
    public static function createEntityManager(){
        return EMFactory::getInstance()->getEntityManager();
    }

    public static function createEntityManagerConsole(){
        return EMFactory::getInstance()->getEntityManager();
    }

    public static function createEntityManagerTest(){
        return EMFactory::getInstance()->getTestEntityManager();
    }
}