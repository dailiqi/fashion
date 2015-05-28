<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class SearchMixShareInfoPage extends CBaseFormModel {

    public $id;
    public $get_array = array(
        "id"
    );

    public function rules() {
        return array(//            array("username, password", "required")
        );
    }

    public function _execute() {
        $mix = Mix::model()->findByPk($this->id);

//        return $mix;
    }
}