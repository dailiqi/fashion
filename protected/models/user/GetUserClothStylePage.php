<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class GetUserClothStylePage extends CBaseFormModel {

    public $get_array = array();

    public function rules() {
        return array();
    }

    protected function _execute() {
        try {
            $criteria = new CDbCriteria();
            $criteria->select = 'sum(is_sweety) as is_sweety,'
                . 'sum(is_lightripe) as is_lightripe, sum(is_preppy) as is_preppy,'
                . 'sum(is_handsome) as is_handsome, sum(is_punk) as is_punk,'
                . 'sum(is_bf) as is_bf, sum(is_classic) as is_classic, sum(is_art) as is_art,'
                . 'sum(is_morigirl) as is_morigirl, sum(is_commute) as is_commute, sum(is_sport) as is_sport';
            $criteria->addCondition('user_id=:user_id');
            $criteria->params = array('user_id' => LoginPage::$user->id);
            $sum = ClothExt::model()->find($criteria);
            $ret = array();
            if($sum->is_sweety) {
                $ret[] = 11;
            }
            if($sum['is_lightripe']) {
                $ret[] = 12;
            }
            if($sum['is_preppy']) {
                $ret[] = 13;
            }
            if($sum['is_handsome']) {
                $ret[] = 21;
            }
            if($sum['is_punk']) {
                $ret[] = 22;
            }
            if($sum['is_classic']) {
                $ret[] = 31;
            }
            if($sum['is_art']) {
                $ret[] = 32;
            }
            if($sum['is_morigirl']) {
                $ret[] = 33;
            }
            if($sum['is_commute']) {
                $ret[] = 41;
            }
            if($sum['is_sport']) {
                $ret[] = 42;
            }

            return array("error_no" => 0, 'data' => array('list' => $ret));
        } catch(Exception $e) {
            //TODO 添加日志
            Yii_Log::warning(array('error_no' => $e->getCode(), 'error_message' => $e->getMessage()));
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }
}