<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);
// including Yii
$dir = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
require_once($dir.'/framework/yii-1.1.13.e9e4a0/framework/yii.php');
// we'll use a separate config file
$configFile=$dir.'/conf/console.php';
// creating and running console application
Yii::createConsoleApplication($configFile)->run();
?>
