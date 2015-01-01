<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15-1-1
 * Time: 下午10:30
 */
class AddMixCommentPage extends CBaseFormModel {
    public $mix_id;
    public $user_id;
    public $comment;
    public $post_array = array(
        "mix_id", "user_id", "comment",
    );

    protected function _execute() {
        $mixComment = new MixComment();
        $mixComment->mix_id = intval($this->mix_id);
        $mixComment->user_id = intval($this->user_id);
        $mixComment->comment = $this->comment;
        $mixComment->time = time();
        $mixComment->save();
    }
}