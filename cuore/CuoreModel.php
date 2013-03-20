<?php
class CuoreModel {
    static $fetch_type = PDO::FETCH_OBJ;
    static $query;
    
    function save()
    {
       $vars = array_keys(get_object_vars($this));
       $values = array();
       
       foreach($vars as  $var) {
           if (isset($this->$var)) {
            $values[$var] = $this->$var;
           }
       }

       if (isset($this->id) && isset($this->id)) {
           unset($values['id']);
           CuoreDb::update(static::$table," AND id = '{$this->id}'", $values);
       } else {
           CuoreDb::insert(static::$table, $values);
           $this->setId(CuoreDb::$last_inserted_id);
       }
       
       return $this;
    }
    
    function noTotal()
    {
        $query = preg_replace(array('/select(.*?)from/i', '/( limit .*?)/'), array('select count(*) as total from ', ' '), self::$query);
        return CuoreDb::fetchOne($query)->total;
    }
    
    function fetchAll($query = '', $where = '', $params = array())
    {
        if (!$query) {
            $query = "select * from " . static::$table;
        }
        self::$query = $query;
        return CuoreDb::fetchAll($query . " " . $where, $params, static::$fetch_type , 0, get_called_class());
    }
    
    function fetchAllAssoc($query = '', $assoc_key = 'id', $where = '', $params = array())
    {
        if (!$query) {
            $query = "select * from " . static::$table;
        }
        self::$query = $query;
        return CuoreDb::fetchAllAsooc($query . " " . $where, $assoc_key, $params, static::$fetch_type , get_called_class());
    }
    
    function getOneById($id, $query = '', $where = '')
    {
        if (!$query) {
            $query = "select * from " . static::$table . " where id = ?";
        }
        return CuoreDb::fetchOne($query ." ". $where, array($id), static::$fetch_type, 0, get_called_class());
    }
    
    function getById($id)
    {
        return self::getOneById($id);
    }

}
?>