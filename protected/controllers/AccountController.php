<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class AccountController extends CController {

    public function actionLogin() {
        $page=new LoginPage();
        $ret = $page->execute();
        echo CJSON::encode($ret);
    }
    public function actionRegister() {
        $page=new RegisterPage();
        $ret = $page->execute();
        echo CJSON::encode($ret);
    }
    public function actionSetUserInfo() {
        $page=new SetUserInfoPage();
        $ret = $page->execute();
        echo CJSON::encode($ret);
    }

    public function actionError() {           
        if($error=Yii::app()->errorHandler->error){
             echo $error['message'];
        }
    }

    public function filters() {
        return array(
            array('application.extensions.CLoginFilter',)
            );
    }
}
