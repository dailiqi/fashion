<?php
define('ROOT', dirname(dirname(__FILE__)));
define('BASE_DIR', ROOT . "/app/fashion/protected");
require(ROOT . "/../../../conf/otherparams.php");
global $g_db;
return array(
    "basePath" => ROOT,
    "name" => 'My Console Application',
    'import' => array(
        'application.models.page.*',
        'application.models.dao.*',
        'application.models.service.*',
        'application.components.*',
        'application.extensions.*',
    ),
    'components' => array(
        'smarty' => array(
            'class' => 'application.extensions.CSmarty',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=fashion',
            'username' => 'root',
            'password' => '',
        ),
    ),
);
