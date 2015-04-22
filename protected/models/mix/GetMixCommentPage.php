<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15-1-1
 * Time: 下午10:30
 */
class GetMixCommentPage extends CBaseFormModel {
    public $mix_id;
    public $page_num;
    public $get_array = array(
        "mix_id", "page_num"
    );

    protected function _execute() {
        $sql = 'select mix_comment.id as id ,' .
            'mix_comment.comment as comment, ' .
            'mix_comment.user_id as user_id,' .
            'user.user_name as user_name,' .
            'mix_comment.time as time' .
            ' from mix_comment,user where mix_comment.mix_id=' . intval($this->mix_id) .
            ' and mix_comment.user_id=user.id ' .
            ' order by time desc limit ' . intval($this->page_num) * 10 . ', 10 ';
        $connection = Yii::app()->db;   // 假设你已经建立了一个 "db" 连接
        $command = $connection->createCommand($sql);
        $list = $command->queryAll();      // 查询并返回结果中的所有行
        return $list;

    }
}