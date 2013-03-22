<?php 
class CuoreView {
	static public $variables = array();
	static public $tpl_changed = false;
     /* 1 hour cache expire time */
	static public $cache_time = 216000;
	static public $cache_dir;
	static public $tpl_dir;
    
    function init() {
        if (self::$cache_dir && !is_dir(self::$cache_dir)) {
            mkdir(self::$cache_dir, 0777, true);
        }
    }
    
    function load($path, $variables = array()) {
		self::$variables = array_merge(self::$variables, $variables);
        extract(self::$variables);        
        $full_path = self::$tpl_dir . $path;
        include($full_path);
        $keys = array_keys($variables);
        /* reload the variables with the new values 
         * (the variables have been modified in the tpl)*/
        foreach($keys as $key) {
            self::$variables[$key] = ${$key};
        }
    }
    
	function cache($path, $variables = array(), $force_cache = false) {
		self::$variables = array_merge(self::$variables, $variables);
        extract(self::$variables);        
        $full_path = self::$tpl_dir . $path;
        $tmp_prefix = preg_replace('/[^a-zA-Z0-9]/', '%', $path);
        $tmp_cache_file = self::$cache_dir . $tmp_prefix .'_'.md5(filesize($full_path) . print_r($variables, true));
        $now = time();
        if (!file_exists($tmp_cache_file) || ((self::$cache_time == -1 || $force_cache || (($now - filemtime($tmp_cache_file)) > self::$cache_time)) && self::$cache_time) ) {
            self::$tpl_changed = true;
            ob_start();

            include($full_path);
            /* reload the variables with the new values 
             * (the variables have been modified in the tpl)
             */
            $keys = array_keys($variables);
            foreach($keys as $key) {
                self::$variables[$key] = ${$key};
            }
            $old_tmp_cache_file = array_pop(glob(self::$cache_dir . $tmp_prefix . '_*'));
            if ($old_tmp_cache_file) {
                unlink($old_tmp_cache_file);
            }
            file_put_contents($tmp_cache_file, ob_get_contents());
            ob_clean();        
            include($tmp_cache_file);
        } else {
            include($tmp_cache_file);
        }
	}
	
    
	function assign($name, $value) {
		self::$variables[$name] = $value;		
	}
}

?>