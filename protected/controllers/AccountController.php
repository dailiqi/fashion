<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class AccountController extends BaseController {

    public $defaultAction = "login";

    public function actionLogin() {
        $page = new LoginPage();
        $ret = $page->execute();
        $this->json($ret);
    }

    public function actionRegister() {
        $page = new RegisterPage();
        $ret = $page->execute();
        $this->json($ret);
    }
}
