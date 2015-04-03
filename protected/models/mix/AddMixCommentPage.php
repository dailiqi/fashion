<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15-1-1
 * Time: 下午10:30
 */
class AddMixCommentPage extends CBaseFormModel {
    public $mix_id;
    public $comment;
    public $get_array = array(
        "mix_id", "comment",
    );

    protected function _execute() {
        try {
            $mixComment = new MixComment();
            $mixComment->mix_id = intval($this->mix_id);
            $mixComment->user_id = LoginPage::$user->id;
            $mixComment->comment = $this->comment;
            $mixComment->time = time();
            $mixComment->save();

            return array("error_no" => 0, 'data' => 'success');
        } catch(Exception $e) {
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }
}