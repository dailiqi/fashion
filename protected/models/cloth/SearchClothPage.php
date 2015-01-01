<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class SearchClothPage extends CBaseFormModel {
    public $color_id;
    public $fabric_id;
    public $fabric_sub_id;
    public $contour;
    public $specific;
    public $cloth_type;
    public $cloth_sub_type;
    public $page_num;


    public $get_array = array(
        "color_id", "fabric_id",
        "fabric_sub_id", "contour",
        "specific", "cloth_type",
        "cloth_sub_type", "page_num",
    );

    public function rules() {
        return array();
    }

    protected function _execute() {
        try {
            $criteria = new CDbCriteria();
            if(LoginPage::$user) {
                $criteria->addCondition('user_id=:user_id');
                $criteria->params['user_id'] = LoginPage::$user->id;
            }
            $criteria->order = 'id desc';

            if($this->color_id) {
                $criteria->addCondition('color_id=:color_id');
                $criteria->params['color_id'] = $this->color_id;
            }
            if($this->fabric_id) {
                $criteria->addCondition('fabric_id=:fabric_id');
                $criteria->params['fabric_id'] = $this->fabric_id;
            }
            if($this->fabric_sub_id) {
                $criteria->addCondition('fabric_sub_id=:fabric_sub_id');
                $criteria->params['fabric_sub_id'] = $this->fabric_sub_id;
            }
            if($this->contour) {
                $criteria->addCondition('contour=:contour');
                $criteria->params['contour'] = $this->contour;
            }
            if($this->specific) {
                $criteria->addCondition('specific=:specific');
                $criteria->params['specific'] = $this->specific;
            }
            if($this->cloth_type) {
                $criteria->addCondition('cloth_type=:cloth_type');
                $criteria->params['cloth_type'] = $this->cloth_type;
            }
            if($this->cloth_sub_type) {
                $criteria->addCondition('cloth_sub_type=:cloth_sub_type');
                $criteria->params['cloth_sub_type'] = $this->cloth_sub_type;
            }
            $count = Cloth::model()->count($criteria);

            $criteria->limit = 10;
            if(!$this->page_num) {
                $this->page_num = 1;
            }
            $criteria->offset = ($this->page_num - 1) * 10;

            $list = Cloth::model()->findAll($criteria);

            return array("error_no" => 0, 'data' => array('page_num' => $this->page_num, 'count' => $count, 'list' => $list));
        } catch(Exception $e) {
            //TODO 添加日志
            Yii_Log::warning(array('error_no' => $e->getCode(), 'error_message' => $e->getMessage()));
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }
}