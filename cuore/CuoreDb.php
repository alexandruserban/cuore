<?php
class CuoreDb
{
    static $conn;
    static $last_inserted_id;
    static $query;
    static $sth;
    static $rows_affected;
    
    function connect($host, $user, $pass, $db = '') {
        self::$conn = new PDO("mysql:dbname={$db};host={$host}", $user, $pass);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    function fetchAllAsooc($query, $assoc_key = 'id', $params = array(), $type = PDO::FETCH_OBJ, $fetch_class = '') {
         $res = self::fetchAll($query, $params, $type, 0, $fetch_class);
         $new_res = array();
         foreach ($res as $k=>$row) {
             if (!is_callable($assoc_key)) {
                $new_res[$row->$assoc_key] = $row;
             } else {
                 $new_assoc_key = call_user_func($assoc_key, array($row));
                 $new_res[$new_assoc_key] = $row;
             }
         }
         
         return $new_res;
    }
    
    function fetchAll($query, $params = array(), $type = PDO::FETCH_OBJ, $groupby_first_column = 0, $fetch_class = '') {
        self::$query = $query;
        self::$sth = self::prepare(self::$query);
        $res = array();
        
        if (self::execute($params)) {
            if ($fetch_class) {
                $res = self::$sth->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $fetch_class);
            } elseif (!$groupby_first_column) {
                $res = self::$sth->fetchAll($type);
            } else {
                $res = self::$sth->fetchAll($type|PDO::FETCH_GROUP);
            }
        }
        
        return $res;
    }
    
    function prepare($query)
    {
        return self::$sth = self::$conn->prepare($query);
    }
    
    function execute($params = array())
    {
        return self::$sth->execute($params);
    }
    
    function beginTransaction()
    {
        return self::$conn->beginTransaction();
    }  
    
    function commit()
    {
        return self::$conn->commit();
    }
    
    function rollBack()
    {
        return self::$conn->rollBack();
    }
    
    function getLastInsertedId()
    {
        return self::$conn->lastInsertId();
    }
    
    function getRowsAffected()
    {
        return self::$sth->rowCount();
    }
    
    function fetchOne($query, $params = array(), $type = PDO::FETCH_OBJ, $groupby_first_column = 0, $fetch_class = '') {    
        return array_shift(self::fetchAll($query, $params, $type, $groupby_first_column, $fetch_class));
    }
    
    function fetchObject($query, $params = array(), $type = PDO::FETCH_OBJ, $groupby_first_column = 1){
        return self::fetchAll($query, $params, $type, $groupby_first_column);
    }
    
    function fetchArray($query, $params = array(), $type = PDO::FETCH_COLUMN, $groupby_first_column  = 1){
        return self::fetchAll($query, $params, $type, $groupby_first_column);
    }
    
    function query($query, $params = array()) {
        if (!count($params)) {
            $res = self:: $conn->query($query);
        } else {
            self::prepare($query);
            $res = self::execute($params);
        }
        self::$last_inserted_id = self::getLastInsertedId();
        self::$rows_affected = self::getRowsAffected();
        
        return $res;
    }
    
    function update($table, $where, $values = array())
    {
        $sql = "update " . $table . " set ";
        $fields = array_keys($values);
        $sql .= implode(' = ? , ', $fields) . ' = ?';
        $sql .= ' where 1 = 1 ' . $where;
        self::query($sql, array_values($values));
        
        return self::$rows_affected;
    }
    
    function insert($table, $values = array())
    {
        $sql = "insert into " . $table . " (";
        $sql .= implode(',', array_keys($values)) . ') values (' . implode(',', array_fill(0, count($values), '?')) . ')';        
        self::query($sql, array_values($values));
        
        return self::$last_inserted_id;
    }
    
    function getDBTables($db_name, $type = PDO::FETCH_COLUMN, $groupby_first_column = 0){
        return self::fetchAll("show tables in `{$db_name}`", array(), $type, $groupby_first_column);
    }
    
    function getTableFields($db_name, $table_name, $type = PDO::FETCH_COLUMN, $groupby_first_column = 0){
        return self::fetchAll("show columns in `{$db_name}`.`{$table_name}`", array(), $type, $groupby_first_column);
    }
    
}

