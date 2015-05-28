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

    public function actionSearchUserCollectMix() {
        $page = new SearchUserCollectMixPage();
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

    /**
     * 摇一摇 获取随即的搭配
     */
    public function actionRandomMix() {
        $page = new RandomMixPage();
        $this->json($page->execute());
    }

    public function filters() {
        return array(
            array('application.extensions.CLoginFilter - getGeekList,GetMixComment')
        );
    }
}
