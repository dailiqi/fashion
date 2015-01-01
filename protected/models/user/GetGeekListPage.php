<?php

/**
 *
 * User: rik
 * Date: 14-12-20
 * Time: 上午11:57
 */
class GetGeekListPage extends CBaseFormModel {


    public $get_array = array();

    public function _execute() {
        try {
            $criteria = new CDbCriteria();
            $criteria->order = 'cloth_count desc';
            $criteria->limit = 10;
            $list = UserOpenSummary::model()->findAll($criteria);
            $ret = array();
            foreach($list as $one) {
                $user = User::model()->find('id=:id', array('id' => $one->user_id));
                $tmp['count'] = $one->cloth_count;
                $tmp['user_id'] = $user->id;
                $tmp['nick_name'] = $user->nick_name;
                $tmp['profile_url'] = $user->profile_url;
                $ret[] = $tmp;
            }
            return array("error_no" => 0, 'data' => array('geekList' => $ret));
        } catch(Exception $e) {
            Yii_Log::warning(array('error_no' => $e->getCode(), 'error_message' => $e->getMessage()));
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }

} 