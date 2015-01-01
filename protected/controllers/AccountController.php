<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class AccountController extends CController {

    public $defaultAction = "login";

    public function actionLogin() {
        $page = new LoginPage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }

    public function actionRegister() {
        $page = new RegisterPage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }
}
