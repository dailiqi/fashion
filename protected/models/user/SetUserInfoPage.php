<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:14
 */
class SetUserInfoPage extends CBaseFormModel {
    public $stature;
    public $weight;
    public $feature;
    public $somatotype;
    public $complexion;
    public $get_array = array(
        "stature", "weight",
        "feature", "somatotype",
        "complexion",
    );

    public function _execute() {

        if(!LoginPage::$user) {
            throw new Exception('用户信息错误', 10001);
        }

        $userInfo = UserInfo::model()->find('user_id=:user_id', array('user_id' => LoginPage::$user->id));
        if(!$userInfo) {
            $userInfo = new UserInfo();
        }
        $userInfo->id = LoginPage::$user->id;
        $userInfo->user_id = LoginPage::$user->id;
        if(isset($this->stature)) {
            $userInfo->stature = $this->stature;
        }
        if(isset($this->weight)) {
            $userInfo->weight = $this->weight;
        }
        if(isset($this->feature)) {
            $userInfo->feature = $this->feature;
        }
        if(isset($this->somatotype)) {
            $userInfo->somatotype = $this->somatotype;
        }
        if(isset($this->complexion)) {
            $userInfo->complexion = $this->complexion;
        }
        $userInfo->save();
        return 'success';
    }

} 