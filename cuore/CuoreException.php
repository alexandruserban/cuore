<?php
class CuoreException extends Exception{
    static public $errors = array(
        'E00' => array('code' => 'E00', 'message' => 'Unknown error !'),
        'E01' => array('code' => 'E01', 'message' => 'No route goes by this name: %s'),
        
    );
    
    function __construct($code = '', $msg = '', $string = '')
    {
        $code = strtoupper($code);
        if (!isset(self::$errors[$code])) { 
            $this->message = $msg; 
            $this->code = $code; 
        } else {
            $this->message = sprintf(self::$errors[$code]['message'], $string);
            $this->code = $code;
        }

    }
    
}

