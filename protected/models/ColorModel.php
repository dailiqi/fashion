<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15/4/21
 * Time: 下午5:01
 */
class ColorModel {

    protected $code = 000;

    protected $str = '';

    public function getStr() {
        return $this->str;
    }

    public function getCode() {
        return $this->code;
    }

    public function getStyle() {
        return array();
    }
}