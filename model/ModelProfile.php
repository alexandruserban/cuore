<?php
class ModelProfile extends CuoreModel {
    static public $table = 'profile';
    public $id;
    public $user_id;
            
    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        return $this->id = $id;
    }            
    function getUserId()
    {
        return $this->user_id;
    }
    function setUserId($user_id)
    {
        return $this->user_id = $user_id;
    }
}
