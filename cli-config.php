<?php
require 'vendor/autoload.php';

use app\components\EMFactory;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$entityManager = EMFactory::getInstance()->getEntityManager();

//-- This I had to add to support the Mysql enum type.
$platform = $entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');

return new HelperSet([
    'em' => new EntityManagerHelper($entityManager),
    'db' => new ConnectionHelper($entityManager->getConnection()),
]);