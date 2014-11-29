<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class ClothController extends CController {

    public function addCloth() {
        $page=new AddClothPage();
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
