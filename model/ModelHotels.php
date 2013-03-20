<?php
class ModelHotels extends CuoreModel {
    static protected $table = 'hotels';
    protected $id;
            
    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        return $this->id = $id;
    }
}
;?>