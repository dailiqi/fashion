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
        '1' => array(
            'contour' => array('A', 'X', 'H'),
            'specific' => array(1, 2, 5)
        ),
        //中间型
        '2' => array(
            'contour' => array('A', 'X', 'S', 'H'),
            'specific' => array(2, 3, 4, 5)
        ),
        //直线型
        '3' => array(
            'contour' => array('A', 'X', 'S'),
            'specific' => array(4, 5)
        ),
    );
    static $somatotypeList = array(
        // 1沙漏
        //	A型、X型、S型
        '1' => array(
            'contour' => array('A', 'X', 'S'),
        ),
        //2V型
        '2' => array(
            'contour' => array('A', 'X', 'H'),
        ),
        //3梨子
        '3' => array(
            'contour' => array('A', 'X', 'S'),
        ),
        //4H
        '4' => array(
            'contour' => array('A', 'X'),
        ),
        //5S
        '5' => array(
            'contour' => array('A', 'X', 'S', 'V'),
        ),
        // 6干瘦
        '6' => array(
            'contour' => array('A', 'X', 'H'),
        ),
    );
//`complexion` tinyint(4) NOT NULL default 0 COMMENT '肤色 1白 2偏白略黄 3黄 4偏黑',
    static $complexionList = array(
        '1' => array(
            'color' => array(31, 30, 32, 11, 10, 12, 21, 20, 22, 41, 40, 42, 110, 100, 80, 121, 120, 122, 141, 140, 142, 61, 60, 130),
            'style' => array(11,12,13,23,31,33)//女性化、BF、森女、复古
        ),
        '2' => array(
            'color' => array(51, 50, 52, 40, 42, 61, 140, 100, 91, 31, 21, 120, 122, 10, 12, 92, 70, 100),
            'style' => array(12,13,21,22,23,31,32)
        ),
        '3' => array(
            'color' => array(10, 12, 42, 110, 140, 120, 122, 141, 70, 52, 61),
            'style' => array(12,13,21,23,31,32)
        ),
        '4' => array(
            'color' => array(10, 40, 50, 100, 70, 120, 90, 52, 110, 61, 20, 140, 141),
            'style' => array(12,21,22,23,32)
        ),
    );



    public function analysis($user) {
        $user->feature;
//  `complexion` tinyint(4) NOT NULL default 0 COMMENT '肤色 1白 2偏白略黄 3黄 4偏黑',
    }
}