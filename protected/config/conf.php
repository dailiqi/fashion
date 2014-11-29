<?php
define('ROOT', dirname(dirname(__FILE__)));
require_once(ROOT . '/conf/GlobalConfig.php');
define('BASE_DIR', ROOT . "/app/fashion/protected");

class Config_Fashion {
    public static $config = array(
        "defaultController" => "index",
        "basePath" => BASE_DIR,
        'import' => array(
            'application.models.cloth.*',
            'application.models.dao.*',
            'application.models.user.*',
            'application.components.*',
            'application.extensions.*',
        ),
        'components' => array(
            'smarty' => array(
                'class' => 'application.extensions.CSmarty',
            ),
            'db' => array(
                'connectionString' => 'mysql:host=localhost;port=3306;dbname=fashion',
                'username' => 'root',
                'password' => '',
            ),
        ),
    );
}
