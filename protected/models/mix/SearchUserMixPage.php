<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class SearchUserMixPage extends CBaseFormModel {

    public $for_date;
    public $page_num = 1;
    public $color;//颜色
    public $occasion;//场合
    public $feeling;
//    ，场合，心情参数
    public $get_array = array(
        "for_date", "page_num", "color", "occasion", "feeling"
    );

    public function rules() {
        return array(//            array("username, password", "required")
        );
    }

    public function _execute() {
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

        if($this->color) {
            $criteria->addCondition('color=:color');
            $criteria->params['color'] = $this->color;
        }
        if($this->occasion) {
            $criteria->addCondition('occasion=:occasion');
            $criteria->params['occasion'] = $this->occasion;
        }
        if($this->feeling) {
            $criteria->addCondition('feeling=:feeling');
            $criteria->params['feeling'] = $this->feeling;
        }
        $count = Mix::model()->count($criteria);

        $criteria->limit = 10;
        if(!$this->page_num) {
            $this->page_num = 1;
        }
        $criteria->offset = ($this->page_num - 1) * 10;

        $list = Mix::model()->findAll($criteria);

        return array('page_num' => $this->page_num, 'count' => $count, 'list' => $list);
    }
}