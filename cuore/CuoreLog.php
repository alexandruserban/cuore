<?php
class CuoreLog
{
// TODO change the name from CuoreConfig::$dir to $dir and add static::$logs_dir here
    static $file;
    static $dir;
    static $delimiter = "\n===========================================================\n";
    
    function log($txt)
    {
        $txt = self::$delimiter . '[' . date('Y-m-d h:i:s') . '] ' . $txt;
        file_put_contents(static::$dir . self::$file, $txt, FILE_APPEND);
    }
    
    function init() {
        if (self::$dir && !is_dir(self::$dir)) {
            mkdir(self::$dir, 0777, true);
        }
    }
}
?>
