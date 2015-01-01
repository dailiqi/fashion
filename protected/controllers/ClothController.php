<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class ClothController extends BaseController {

    public function actionAddClothPage() {

    }
    public function actionAddCloth() {
        $page = new AddClothPage();
        $ret = $page->execute();
        $this->json($ret);
    }

    /**
     * 查询衣服列表
     */
    public function actionSearchCloth() {
        $page = new SearchClothPage();
        $ret = $page->execute();
        $this->json($ret);
    }

    /**
     * 获取衣服选项
     */
    public function getClothOption() {

    }

    public function filters() {
        return array(
            array('application.extensions.CLoginFilter',)
        );
    }
}
