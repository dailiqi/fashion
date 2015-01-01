<?php
date_default_timezone_set('Asia/Shanghai');
error_reporting(10000);
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
require_once(dirname(dirname(__FILE__)).'/protected/config/conf.php');
$config = Config_Fashion::$config;
require_once(dirname(dirname(__FILE__)) . '/yii/framework/yii.php');
// create a Web application instance and run
require_once(dirname(dirname(__FILE__)) . '/protected/base/WebApp.php');
//Yii::createWebApplication($config)->run();
Yii::createApplication('WebApp', $config)->run();
