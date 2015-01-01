<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class UserController extends CController {

    public function actionSetUserInfo() {
        $page = new SetUserInfoPage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }

    public function actionGetUserStyle() {
        $page = new GetUserStylePage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }


    public function actionGetUserClothStyle() {
        $page = new GetUserClothStylePage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }

    public function actionGetGeekList() {
        $page = new GetGeekListPage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }

    public function actionFollow() {
        $page = new FollowPage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }

    public function filters() {
        return array(
            array('application.extensions.CLoginFilter - getGeekList')
        );
    }
}
