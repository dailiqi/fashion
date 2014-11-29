<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 下午2:04
 */
class AddClothPage extends CBaseFormModel {
    public $color_id;
    public $fabric_id;
    public $fabric_sub_id;
    public $contour;
    public $specific;
    public $cloth_type;
    public $cloth_sub_type;


    public $get_array = array(
        "color_id", "fabric_id",
        "fabric_sub_id", "contour",
        "specific", "cloth_type",
        "cloth_sub_type",
    );

    public function rules() {
        return array(//            array("username, password", "required")
        );
    }

    public function execute() {
        try {
            if($_FILES['file']['error'] > 0) {
                return array("error_no" => 1, 'errror_message' => $_FILES["file"]["error"]);
            } else {
                //move_uploaded_file($_FILES['file']['tmp_name'], ROOT . '/data/uploadcredit/'.time() . ' _'.$_FILES['file']['name']);
                $url = '/static/' . LoginPage::$user->id . '/' .
                    md5($_FILES['file']['type'] . $_FILES['file']['size'] . time()) .
                    '.' . $_FILES['file']['type'];
                $imgPath = ROOT . $url;
                move_uploaded_file($_FILES['file']['tmp_name'], $imgPath);
                $cloth = new Cloth();
                $cloth->user_id = LoginPage::$user->id;
                $cloth->time = time();
                $cloth->url = $url;
                $cloth->color_id = $this->cloth_id;
                $cloth->fabric_id = $this->fabric_id;
                $cloth->fabric_sub_id = $this->fabric_sub_id;
                $cloth->contour = $this->contour;
                $cloth->specific = $this->specific;
                $cloth->cloth_type = $this->cloth_type;
                $cloth->cloth_sub_type = $this->cloth_sub_type;
                $cloth->save();
                $cloth_id = $cloth->id;
                $ext = new ClothExt();
                $ext->user_id = $cloth_id;
                $ext->use_count = 0;

//                `id` int(10) NOT NULL,
//  `user_id` int(10) NOT NULL DEFAULT 0,
//  `use_count` int(10) NOT NULL DEFAULT 0,
//  `is_sweety` tinyint(4) NOT NULL DEFAULT 0,
//  `is_lightripe` tinyint(4) NOT NULL DEFAULT 0,
//  `is_preppy` tinyint(4)  NOT NULL DEFAULT 0,
//  `is_handsome` tinyint(4) NOT NULL DEFAULT 0,
//  `is_punk` tinyint(4) NOT NULL DEFAULT 0,
//  `is_bf` tinyint(4) NOT NULL DEFAULT 0,
//  `is_classic` tinyint(4) NOT NULL DEFAULT 0,
//  `is_art` tinyint(4) NOT NULL DEFAULT 0,
//  `is_morigirl` tinyint(4) NOT NULL DEFAULT 0,
//  `is_commute` tinyint(4) NOT NULL DEFAULT 0,
//  `is_sport` tinyint(4) NOT NULL DEFAULT 0,

                return array("error_no" => 0, 'data' => array('serial' => $user->serial));
            }
        } catch(Exception $e) {
            //TODO 添加日志
            Yii_Log::warning(array('error_no' => $e->getCode(), 'error_message' => $e->getMessage()));
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }
} 