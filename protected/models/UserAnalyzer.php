<?php
/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-29
 * Time: 上午10:02
 */

class UserAnalyzer {
//图案加工、工艺加工，袖口处理	领边处理，腰部处理	A型、X型、H型
//`contour` char(4) NOT NULL DEFAULT 0 COMMENT '廓形 H型	A型	V型	X型	O型	S型',
//`specific` tinyint(4) NOT NULL DEFAULT 0 COMMENT '细节 1.图案花边	2.工艺加工	3.领边处理	4.腰部处理	5.袖口处理	6.裤边处理',
    static $featureList = array(
        //曲线形
        '1'=>array(
            'contour'=>array('A','X','H'),
            'specific' => array(1,2,5)
        ),
        //中间型
        '2'=>array(
            'contour'=>array('A','X','S','H'),
            'specific' => array(2,3,4,5)
        ),
        //直线型
        '3'=>array(),
    );
    public function analysis($user) {
        $user->feature;
//        `feature` tinyint(4) NOT NULL default 0 COMMENT '脸型 1曲线形 2中间形 3直线形',
//  `somatotype` tinyint(4) NOT NULL default 0 COMMENT '体型 1沙漏 2V型 3梨子 4H 5S',
//  `complexion` tinyint(4) NOT NULL default 0 COMMENT '肤色 1白 2偏白略黄 3黄 4偏黑',
    }
}