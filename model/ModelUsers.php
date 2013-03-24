<?php
class ModelUsers extends CuoreModel {
    static public $table = 'users';
    public $id;
    public $name;
    public $email;
    public $status;
    public $hash;
            
    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        return $this->id = $id;
    }            
    function getName()
    {
        return $this->name;
    }
    function setName($name)
    {
        return $this->name = $name;
    }            
    function getEmail()
    {
        return $this->email;
    }
    function setEmail($email)
    {
        return $this->email = $email;
    }            
    function getStatus()
    {
        return $this->status;
    }
    function setStatus($status)
    {
        return $this->status = $status;
    }            
    function getHash()
    {
        return $this->hash;
    }
    function setHash($hash)
    {
        return $this->hash = $hash;
    }    
    /*custom methods*/
    function fetchAll()
    {
        $this->fetchAllAssoc();
        
    }
}
;?>