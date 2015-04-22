<?php

/**
 *
 * User: rik
 * Date: 14-12-20
 * Time: 上午11:57
 */
class FollowPage extends CBaseFormModel {

    public $follow_id;

    public $get_array = array('follow_id');

    public function _execute() {
        if(!LoginPage::$user) {
            throw new Exception('用户信息错误', 10001);
        }
        $uf = UserFollow::model()->find('user_id=:user_id and follower_id=:follower_id',
            array('user_id' => $this->follow_id,
                'follower_id' => LoginPage::$user->id));
        if($uf) {
            $uf->is_delete = 0;
            $uf->save();
        } else {
            $uf = new UserFollow();
            $uf->user_id = intval($this->follow_id);
            $uf->follower_id = LoginPage::$user->id;
            $uf->save();
        }
        return 'success';
    }

} 