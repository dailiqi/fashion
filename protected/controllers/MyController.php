<?php
/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15/5/3
 * Time: 下午9:20
 */

class MyController {


    /**
     * 获取我收藏的单品
     */
    public function getCollectCloth() {

    }
    /**
     * 获取我收藏的搭配
     */
    public function getCollectMix() {

    }

    public function filters() {
        return array(
            array('application.extensions.CLoginFilter',)
        );
    }
}