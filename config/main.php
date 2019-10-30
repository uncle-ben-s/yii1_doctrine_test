<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('shop', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'shop');
Yii::setPathOfAlias('components', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'components');
Yii::setPathOfAlias('tests', __DIR__ . DIRECTORY_SEPARATOR);
require_once(__DIR__ . '/../vendor/autoload.php');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=> __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
    'name'=>'Yii Shop Test',
    'viewPath'=> __DIR__ . DIRECTORY_SEPARATOR . '../views',
    'controllerMap' => array(
        'site' => '\app\controllers\SiteController',
        'filterType' => '\app\controllers\FilterTypeController',
        'filter' => '\app\controllers\FilterController',
        'card' => '\app\controllers\CardController',
        'history' => '\app\controllers\HistoryController',
        'currency' => '\app\controllers\CurrencyController',
    ),
    // preloading 'log' component
//    'preload'=>array('log'),
    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),
    'defaultController'=>'site',
    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>false,
        ),
        'authManager'=>array(
            'class'=>'components.PhpAuthManager',
            'defaultRoles'=>array('guest'),
        ),
//        'doctrine'=>[
//            'class' => 'components.DoctrineComponent',
//        ],
        'DI' => [
            'class' => 'components.DI',
        ],
        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<controller:\w+>/<id:\d+>/<action:\w+>'=>'<controller>/<action>',
                'card/<cardId:\d+>/deleteFilter/<filterId:\d+>' => 'card/deleteFilter'
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=> require(__DIR__ . '/params.php'),
);