<?php

class User extends CBaseActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    public static function create($param) {
        $user = new User();
        if(isset($param['nick_name'])) {
            $user->nick_name = $param['nick_name'];
        }
    }
}