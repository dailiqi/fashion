<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class DeleteClothPage extends CBaseFormModel {
    public $cloth_id;

    public function __construct() {
    }

    public $get_array = array(
        "cloth_id"
    );

    public function rules() {
        return array(
            array("cloth_id", "required")
        );
    }

    protected function _execute() {
            $cloth = Cloth::model()->find('cloth_id=:cloth_id and user_id=:user_id',
                array('user_id' => LoginPage::$user->id, 'cloth_id' => $this->cloth_id));
            $cloth->delete();
            return 'success';

    }
} 