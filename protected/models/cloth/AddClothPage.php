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

    public function _execute() {
        if($_FILES['file']['error'] > 0) {
            return array("error_no" => 1, 'errror_message' => $_FILES["file"]["error"]);
        } else {
            $url = 'static/' . LoginPage::$user->id . '/' .
                md5($_FILES['file']['type'] . $_FILES['file']['size'] . time()) .
                '.jpg';
            $imgPath = IMG_PATH . $url;
            move_uploaded_file($_FILES['file']['tmp_name'], $imgPath);
            $img = imagecreatefromjpeg($imgPath);
            $x = imagesx($img);
            $y = imagesy($img);
            $cloth = new Cloth();
            $cloth->user_id = LoginPage::$user->id;
            $cloth->time = time();
            $cloth->url = $url;
            $cloth->x = $x;
            $cloth->y = $y;
            if($this->color_id)
                $cloth->color_id = $this->color_id;
            if($this->fabric_id)
                $cloth->fabric_id = $this->fabric_id;
            if($this->fabric_sub_id)
                $cloth->fabric_sub_id = $this->fabric_sub_id;
            if($this->contour)
                $cloth->contour = $this->contour;
            if($this->specific)
                $cloth->specific = $this->specific;
            if($this->cloth_type)
                $cloth->cloth_type = $this->cloth_type;
            if($this->cloth_sub_type)
                $cloth->cloth_sub_type = $this->cloth_sub_type;

            $cloth->save();
            $cloth_id = $cloth->id;
            $ext = new ClothExt();
            $ext->id = $cloth_id;
            $ext->user_id = LoginPage::$user->id;
            $ext->use_count = 0;

            $data = array('color' => $this->color_id, 'contour' => $this->contour);
            $styleList = UserAnalyzer::getStyleByCloth($data);
            foreach($styleList as $key => $value) {
                $key = 'is_' . $value;
                $ext->$key = 1;
            }
            $ext->save();
            return array('file' => $_FILES, 'img_path' => $imgPath, 'data' => json_decode(CJSON::encode($cloth), true));
        }
    }
} 