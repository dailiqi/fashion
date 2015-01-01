<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class SearchUserMixPage extends CBaseFormModel {

    public $for_date;
    public $page_num;
    public $get_array = array(
        "for_date", "page_num"
    );

    public function rules() {
        return array(//            array("username, password", "required")
        );
    }

    public function _execute() {
        try {
            $criteria = new CDbCriteria();
            if(LoginPage::$user) {
                $criteria->addCondition('user_id=:user_id');
                $criteria->params['user_id'] = LoginPage::$user->id;
            }
            $criteria->order = 'id desc';

            if($this->for_date) {
                $criteria->addCondition('for_date=:for_date');
                $criteria->params['for_date'] = $this->for_date;
            }
            $count = Mix::model()->count($criteria);

            $criteria->limit = 10;
            if(!$this->page_num) {
                $this->page_num = 1;
            }
            $criteria->offset = ($this->page_num - 1) * 10;

            $list = Mix::model()->findAll($criteria);

            return array("error_no" => 0, 'data' => array('page_num' => $this->page_num, 'count' => $count, 'list' => $list));
        } catch(Exception $e) {
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }
}