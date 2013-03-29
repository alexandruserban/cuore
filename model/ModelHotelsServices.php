<?php
class ModelHotelsServices extends CuoreModel {
    static public $table = 'hotels_services';
    public $id;
    public $id_hotels;
    public $id_services;
            
    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        return $this->id = $id;
    }            
    function getIdHotels()
    {
        return $this->id_hotels;
    }
    function setIdHotels($id_hotels)
    {
        return $this->id_hotels = $id_hotels;
    }            
    function getIdServices()
    {
        return $this->id_services;
    }
    function setIdServices($id_services)
    {
        return $this->id_services = $id_services;
    }
}
