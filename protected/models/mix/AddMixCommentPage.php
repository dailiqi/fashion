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
        $mixComment = new MixComment();
        $mixComment->mix_id = intval($this->mix_id);
        $mixComment->user_id = LoginPage::$user->id;
        $mixComment->comment = $this->comment;
        $mixComment->time = time();
        $mixComment->save();

        return 'success';
    }
}