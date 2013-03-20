<?php
class CuoreLog
{
    static $delimiter = "\n===========================================================\n";
    
    function log($txt)
    {
        $txt = self::$delimiter . '[' . date('Y-m-d h:i:s') . '] ' . $txt;
        file_put_contents(CuoreConfig::$core['log_file_path'], $txt, FILE_APPEND);
    }
}
?>
