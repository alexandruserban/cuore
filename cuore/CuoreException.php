<?php
class CuoreException extends Exception{
    static public $errors = array(
        'E00' => array('code' => 'E00', 'message' => 'Unknown error !'),
        'E01' => array('code' => 'E01', 'message' => 'No controller goes by this description.'),
        
    );
    
    function __construct($code = '', $msg = '')
    {
        $code = strtoupper($code);
        if (!isset(self::$errors[$code])) { 
            $this->message = $msg; 
            $this->code = $code; 
        } else {
            $this->message = self::$errors[$code]['message'];
            $this->code = $code;
        }

    }
    
}
?>
