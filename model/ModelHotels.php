<?php
class ModelHotels extends CuoreModel {
    static public $table = 'hotels';
    public $id;
            
    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        return $this->id = $id;
    }
}
