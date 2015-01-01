<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 15-1-1
 * Time: 下午10:26
 */
class BaseController extends CController {

    public function json($ret) {
        header('Content-Type: application/json');
        echo CJSON::encode($ret);
    }
}