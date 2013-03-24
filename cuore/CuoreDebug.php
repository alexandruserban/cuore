<?php
class CuoreDebug
{
    private static $is_admin = true;
    private static $start_delimiter  = "<br/>\\\=====================<small>%s</small>=====================//</br>";
    private static $end_delimiter  = "<br/>//=====================<small>%s</small>=====================\\\</br>";
    
    function printr($txt, $exit = false) {
        if(self::$is_admin) {
            echo sprintf(self::$start_delimiter, date('Y-m-d h:i:s'));
            //print_r(debug_backtrace());
            echo "<pre>" . print_r($txt, true) . '<br/>.............................<br/>' . 
                    print_r(array_map(function ($val) {
                        $val = array_merge(array('file' => '', 'class' => '', 'function' => '', 'line' => ''), $val);
                        return "<b>F</b>: {$val['file']} -> <b>C</b>: {$val['class']} -> <b>M</b>: {$val['function']} -> <b>L</b>: {$val['line']}";
                    }, array_slice(debug_backtrace(), 1)), true) 
                . "</pre>";
            if ($exit) {
                exit();
            }
            
            echo sprintf(self::$end_delimiter, date('Y-m-d h:i:s'));
        }
    }
}

