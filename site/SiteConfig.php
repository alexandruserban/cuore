<?php 
/*namespace site;

use \CuoreConfig as CuoreConfig;
use \CuoreRoute as CuoreRoute;
use \CuoreDebug as CuoreDebug;
use \CuoreView as CuoreView;
use \CuoreController as CuoreController;
use \CuoreDb as CuoreDb;
use \CuoreLog as CuoreLog;*/

class SiteConfig extends CuoreConfig {
    
	function init() 
    {
		parent::init();
		/* path */
		self::$path['templates'] = self::$path['base']. 'templates/';
		
		/* urls */
		self::$url['base'] = 'http://cuore.lo';//$_SERVER['SERVER_NAME'];
	
		/* DB */
		self::$db['host'] = '127.0.0.1';
		self::$db['user'] = 'test';
		self::$db['pass'] = '';
		self::$db['db'] = 'test';
	}
    
	function initDev() 
    {
        self::init();
        /* renews cache everytime */
        self::$core['cache_time'] = -1;
	}
}
?>