<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class ClothController extends CController {

    public function actionAddClothPage() {

    }
    public function actionAddCloth() {
        $page = new AddClothPage();
        $ret = $page->execute();
        echo CJSON::encode($ret);
    }

    /**
     * 获取衣服选项
     */
    public function getClothOption() {

    }

    public function getClothList() {

    }

    public function actionError() {
        if($error = Yii::app()->errorHandler->error) {
            echo $error['message'];
        }
    }

    public function filters() {
        return array(
            array('application.extensions.CLoginFilter',)
        );
    }
}
