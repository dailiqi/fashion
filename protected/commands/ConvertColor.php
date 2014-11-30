<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-29
 * Time: 下午4:38
 */
class ConvertColor {
    static $colorHash = array(
        '正红'=>'10',
        '浅红'=>'11',
        '深红'=>'12',
        '正橘'=>'20',
        '浅橘'=>'21',
        '深橘'=>'22',
        '正黄'=>'30',
        '浅黄'=>'31',
        '深黄'=>'32',
        '正绿'=>'40',
        '浅绿'=>'41',
        '深绿'=>'42',
        '正蓝'=>'50',
        '浅蓝'=>'51',
        '深蓝'=>'52',
        '正紫'=>'60',
        '浅紫'=>'61',
        '深紫'=>'62',
        '黑'=>'70',
        '白'=>'80',
        '正灰'=>'90',
        '浅灰'=>'91',
        '深灰'=>'92',
        '银'=>'100',
        '金'=>'110',
        '正粉'=>'120',
        '浅粉'=>'121',
        '深粉'=>'122',
        '肉粉'=>'130',
        '正杏'=>'140',
        '浅杏'=>'141',
        '深杏'=>'142',
    );

    public static function test($str) {
        $colors = explode('、', $str);
        var_dump($colors);
        $codeList = array();
        foreach($colors as $one) {
            $tmp_str = str_replace('色', '', $one);
            if(array_key_exists($tmp_str, self::$colorHash)) {
                $code = self::$colorHash[$tmp_str];
                $codeList[] = $code;
            } else {
                $tmp_str = '正' . $tmp_str;
                $code = self::$colorHash[$tmp_str];
                if($code) {
                    $codeList[] = $code;
                } else {
                    echo $tmp_str;
                }
            }
        }
        echo implode(',', $codeList);
    }
    public static function values() {
        foreach(self::$colorHash as $color) {
            $tmp[] = $color;
        }
        echo implode(',', $tmp);
    }
}

//ConvertColor::test('红色、深红、黄色、深黄、绿色、深绿、紫色、深紫色、蓝色、深蓝色、浅蓝色、橘色、深橘色、黑色、深灰色、金色、银色');
ConvertColor::values();