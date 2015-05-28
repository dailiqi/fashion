<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class SearchUserCollectMixPage extends CBaseFormModel {

    public $page_num;
    public $get_array = array(
        "page_num"
    );

    public function rules() {
        return array(
        );
    }

    public function _execute() {
        $criteria = new CDbCriteria();
        if(LoginPage::$user) {
            $criteria->addCondition('user_id=:user_id');
            $criteria->params['user_id'] = LoginPage::$user->id;
        }
        $criteria->addCondition('is_delete=0');

        $count = UserCollect::model()->count($criteria);

        $criteria->limit = 10;
        if(!$this->page_num) {
            $this->page_num = 1;
        }
        $criteria->offset = ($this->page_num - 1) * 10;

        $list = UserCollect::model()->findAll($criteria);
        $cloth = array();
        foreach($list as $one) {
            $cloth[] = Mix::model()->findByPk($one->mix_id);
        }

        return array('page_num' => $this->page_num, 'count' => $count, 'list' => $cloth);
    }
}