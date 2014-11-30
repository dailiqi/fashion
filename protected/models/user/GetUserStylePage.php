<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:14
 */
class GetUserStylePage extends CBaseFormModel {
    public function execute() {
        try {
            if(!LoginPage::$user){
                throw new Exception('用户信息错误', 10001);
            }

            $userInfo = UserInfo::model()->find('user_id=:user_id',array('user_id'=>LoginPage::$user->id));
            if(!$userInfo) {
                $userInfo = new UserInfo();
            }
            $list = UserAnalyzer::getStyleByComplexion($userInfo->complexion);
            return array("error_no" => 0, 'data' => array('styleList'=>$list));
        } catch(Exception $e) {
            Yii_Log::warning(array('error_no' => $e->getCode(), 'error_message' => $e->getMessage()));
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }
}