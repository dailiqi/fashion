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
        $page = new GetMixCommentPage();
        $ret = $page->execute();
        $this->json($ret);
    }

    public function actionAddMixComment() {
        $page = new AddMixCommentPage();
        $ret = $page->execute();
        $this->json($ret);
    }

    public function actionAddMixCollect() {
        $page = new AddMixCollectPage();
        $ret = $page->execute();
        $this->json($ret);
    }
    public function filters() {
        return array(
            array('application.extensions.CLoginFilter - getGeekList,GetMixComment')
        );
    }
}
