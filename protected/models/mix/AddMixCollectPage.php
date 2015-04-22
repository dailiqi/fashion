<?php

/**
 *
 * User: rik
 * Date: 14-12-20
 * Time: 上午11:57
 */
class AddMixCollectPage extends CBaseFormModel {

    public $collect_user_id;
    public $mix_id;

    public $get_array = array('collect_user_id', 'mix_id');

    public function _execute() {
        if(!LoginPage::$user) {
            throw new Exception('用户信息错误', 10001);
        }
        if(LoginPage::$user->id == $this->collect_user_id) {
            throw new Exception('不能关注自己', 50001);
        }
        if(!Mix::model()->find('user_id=:user_id and id=:id', array('user_id' => $this->collect_user_id, 'id' => $this->mix_id))) {
            throw new Exception('未找到关注商品', 50002);
        }
        $uc = UserMixCollect::model()->find('user_id=:user_id and collect_user_id=:collect_user_id and mix_id=:mix_id',
            array('user_id' => LoginPage::$user->id, 'collect_user_id' => $this->collect_user_id, 'mix_id' => $this->mix_id));
        if(!$uc) {
            $uc = new UserMixCollect();
            $uc->collect_user_id = $this->collect_user_id;
            $uc->mix_id = $this->mix_id;
            $uc->user_id = LoginPage::$user->id;
            $uc->time = time();
            $uc->save();
        }
        return 'success';
    }

} 