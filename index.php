<?php
define('BASE_PATH', str_replace('\\', '/',dirname(__FILE__)) . '/');
define('CLASSNAME_SEPARATOR', '_');
define('ENVIRONMENT', 'dev');

/* light autoloader class PHP 5.3 required*/
spl_autoload_register(function ($class) {
    /* if your using namespaceing */
    $class = array_pop(explode('\\', $class));
    
	$path = strtolower(preg_replace(array('/([A-Z])/'), array('/$1'), $class));
	$file = BASE_PATH . substr($path, 1, strrpos($path, '/') - 1) . '/' . $class . '.php';
	
    require_once $file;
});

if (ENVIRONMENT == 'prod') {
	error_reporting(E_ALL);
	ini_set('display_errors', 'off');
	ini_set("log_errors", 1);
	ini_set("error_log", BASE_PATH . "logs/php-error.log");
    
    SiteConfig::init();
} elseif (ENVIRONMENT == 'dev') {
	ini_set('display_errors', 'on');
	error_reporting(E_ALL);
    
    SiteConfig::initDev();
}

SiteRoute::init();
SiteRoute::$controller_prefix = SiteConfig::$core['controller_prefix'];
SiteRoute::$default_controller = SiteConfig::$core['default_controller'];
SiteRoute::$default_method = SiteConfig::$core['default_method'];
        
SiteView::$cache_time = SiteConfig::$core['cache_time'];
SiteView::$tpl_dir = SiteConfig::$path['templates'];
SiteView::$tmp_cache_dir = SiteConfig::$path['tmp_cache_path'];

CuoreDb::connect(CuoreConfig::$db['host'], CuoreConfig::$db['user'], CuoreConfig::$db['pass'], CuoreConfig::$db['db']);

CuoreConsole::$model_prefix = SiteConfig::$core['model_prefix'];
CuoreConsole::$models_dir = SiteConfig::$core['models_dir'];

if (!defined('CONSOLE')) {
    $parts = explode('/', SiteConfig::$url['base']);
    try {
        CuoreRoute::route(preg_replace('/[\/]+/','/',str_replace($parts, array_fill(0, count($parts), ''),
                                        $_SERVER['REQUEST_URI'])));
    } catch (CuoreException $e) {
        echo $e->getMessage();
    }
}