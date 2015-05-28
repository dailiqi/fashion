<?php
/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15/5/3
 * Time: 下午9:54
 */

class RandomMixPage extends CBaseFormModel {

    protected function _execute() {
        $sql = 'select * from mix order by rand() limit 1';
        $connection = Yii::app()->db;   // 假设你已经建立了一个 "db" 连接
        $command = $connection->createCommand($sql);
        $ret = $command->query();      // 查询并返回结果中的所有行
        return $ret;
    }
}