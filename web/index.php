<?php
// change the following paths if necessary
$yii= __DIR__ . '/../vendor/yiisoft/yii/framework/yii.php';
$config= __DIR__ . '/../config/main.php';
// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_ENV_PROD') or define('YII_ENV_PROD',false);

require_once(__DIR__ . '/../vendor/yiisoft/yii/framework/yii.php');

Yii::createWebApplication($config)->run();