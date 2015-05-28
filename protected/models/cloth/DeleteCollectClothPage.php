<?php
/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15/5/28
 * Time: 下午6:23
 */

class DeleteCollectClothPage  extends CBaseFormModel {
    public $id;


    public $get_array = array(
        "id"
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
        $uc = UserCollect::model()->find('user_id=:user_id and is_delete=0', array('user_id'=>LoginPage::$user->id));
        if($uc) {
            $uc->is_delete = 1;
            $uc->save();
            return 'success';
        } else {
            throw new Exception('删除失败，未能找到该收藏信息。',1);
        }

    }
}