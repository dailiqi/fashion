<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class MixController extends BaseController {

    public function actionAddMix() {
        $page = new AddMixPage();
        $ret = $page->execute();
        $this->json($ret);
    }


    public function actionSearchUserMix() {
        $page = new SearchUserMixPage();
        $ret = $page->execute();
        $this->json($ret);
    }

    public function actionGetMixComment() {
        $page = new SearchUserMixPage();
        $ret = $page->execute();
        $this->json($ret);
    }

    public function actionCommentMix() {
        $page = new AddMixCommentPage();
        $ret = $page->execute();
        $this->json($ret);
    }
    public function filters() {
        return array(
            array('application.extensions.CLoginFilter - getGeekList')
        );
    }
}
