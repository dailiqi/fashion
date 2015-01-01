<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15-1-1
 * Time: 下午10:30
 */
class GetMixCommentPage extends CBaseFormModel {
    public $mix_id;
    public $post_array = array(
        "mix_id",
    );

    protected function _execute() {
        return MixComment::model()->find('mix_id=:mix_id', array('mix_id' => $this->mix_id));
    }
}