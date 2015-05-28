<?php

/**
 *
 * User: rik
 * Date: 14-12-20
 * Time: 上午11:57
 */
class GetFollowerListPage extends CBaseFormModel {

    public $user_id;
    public $page_num;

    public $get_array = array('user_id','page_num');

    public function _execute() {
        $criteria = new CDbCriteria();
        if(LoginPage::$user) {
            $criteria->addCondition('user_id=:user_id');
            $criteria->params['user_id'] = LoginPage::$user->id;
        }
        $criteria->order = 'id desc';

        $count = UserFollow::model()->count($criteria);

        $criteria->limit = 10;
        if(!$this->page_num) {
            $this->page_num = 1;
        }
        $criteria->offset = ($this->page_num - 1) * 10;

        $list = UserFollow::model()->findAll($criteria);

        return array('page_num' => $this->page_num, 'count' => $count, 'list' => $list);
    }

} 