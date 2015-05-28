<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class SearchCollectClothPage extends CBaseFormModel {
    public $page_num;
    public $type;


    public $get_array = array(
    "page_num","type"
    );

    public function rules() {
        return array();
    }

    protected function _execute() {
        $criteria = new CDbCriteria();
        if(LoginPage::$user) {
            $criteria->addCondition('user_id=:user_id');
            $criteria->params['user_id'] = LoginPage::$user->id;
        }


        if($this->type) {
            $criteria->addCondition('type=:type');
            $criteria->params['type'] = $this->type;
        }
        $criteria->addCondition('is_delete=0');
        $count = UserCollect::model()->count($criteria);

        $criteria->limit = 10;
        if(!$this->page_num) {
            $this->page_num = 1;
        }
        $criteria->offset = ($this->page_num - 1) * 10;

        $list = UserCollect::model()->findAll($criteria);
        $mix = array();
        foreach($list as $one) {
            $mix[] = Cloth::model()->findByPk($one->mix_id);
        }

        return array('page_num' => $this->page_num, 'count' => $count, 'list' => $mix);

    }
}