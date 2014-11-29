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
    //脸型
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
    //体型
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
    //肤色
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
    //风格
    static $styleList = array(

        '11'=>array(
            'color'=>array(11,10,31,30,32,21,20,22,41,40,42,80,121,120,122,141,140,142,61,60,130),
        ),
        '12'=>array(
            'color'=>array(11,10,12,31,30,32,21,20,22,41,40,42,110,100,80,121,120,122,141,140,142,61,60,62,130,70,91,90,92),
        ),
        '13'=>array(
            'color'=>array(10,12,30,32,40,42,60,62,50,52,51,20,22,70,92,110,100),
        ),
        '21'=>array(
            'color'=>array(70,80,91,90,92,140,142,100,110,42,12,32,10),
        ),
        '22'=>array(
            'color'=>array(10,12,50,52,70,90,92,110,100),
        ),
        '23'=>array(
            'color'=>array(12,30,32,40,42,50,52,70,80,91,90,92,140,142,130,120,122),
        ),
        '31'=>array(
            'color'=>array(10,12,30,32,40,42,60,62,140,142,141,52,51,22,70,92,110,100),
        ),
        '32'=>array(
            'color'=>array(80,141,140,142,12,42,91,90,92,31),
        ),
        '33'=>array(
            'color'=>array(10,11,31,30,32,41,40,42,61,60,62,140,142,141,52,51,22,92,110,100,80),
        ),
        '41'=>array(
            'color'=>array(70,80,90,91,92,120,121,122,10,32,141,140,142,110,100,40,50,52,130),
        ),
        '42'=>array(
            'color'=>array(10,11,12,20,21,22,30,31,32,40,41,42,50,51,52,60,61,62,70,80,90,91,92,100,110,120,121,122,130),
        ),
    );

    /**
     * 根据肤色获取风格
     * @param $complexion
     * @return bool
     */
    public static function getStyleByComplexion($complexion) {
        if(array_key_exists($complexion,self::$complexionList)) {
            $style = self::$complexionList[$complexion];
            return $style;
        }
        return false;
    }

    /**
     * 根据用户获取廓形
     * @param $user
     * @return array
     */
    public function getContourByUser($user) {
        if(array_key_exists($user->feature,self::$featureList)) {
            $contour = self::$featureList[$user->feature];
        }
        if(array_key_exists($user->somatotype,self::$somatotypeList)) {
            $contour1 = self::$somatotypeList[$user->somatotype];
        }
        $ret = array_intersect($contour,$contour1);
        return $ret;
    }

    /**
     * 根据用户及用户选取的风格获取颜色
     * @param $user
     * @param $style
     * @return array
     */
    public function getUserColorByStyle($user,$style) {
        $color = array();
        $color1 = array();
        if(array_key_exists($user->complexion,self::$complexionList)) {
            $color = self::$complexionList[$user->complexion];
        }
        if(array_key_exists($style,self::$styleList)) {
            $color1 = self::$styleList[$style];
        }
        $ret = array_intersect($color,$color1);
        return $ret;
    }
}