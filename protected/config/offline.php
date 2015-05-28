<?php
define('ROOT', dirname(dirname(__FILE__)));
define('LOG_PATH', dirname(dirname(dirname(ROOT))));
define('BASE_DIR', ROOT);
define('IMG_PATH', dirname(ROOT) . '/webroot/');
class Config_Fashion {
    public static $config = array(
        "defaultController" => "index",
        "basePath" => BASE_DIR,
        'import' => array(
            'application.controllers.*',
            'application.models.*',
            'application.models.account.*',
            'application.models.cloth.*',
            'application.models.user.*',
            'application.models.mix.*',
            'application.models.follow.*',
            'application.models.dao.*',
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
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName'=>true,
                'rules'=>array(
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
            ),
        ),
    );
}
