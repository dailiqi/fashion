<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class SearchUserMixDetailPage extends CBaseFormModel {

    public $id;
//    ，场合，心情参数
    public $get_array = array(
        "id"
    );

    public function rules() {
        return array(//            array("username, password", "required")
        );
    }

    public function _execute() {
        $list = Mix::model()->findByPk($this->id);
        return $list;
    }
}