<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class MixController extends CController {

    public function actionAddMix() {
        $page = new AddMixPage();
        $ret = $page->execute();
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }

    public function actionSearchUserMix() {
        $page = new SearchUserMixPage();
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
