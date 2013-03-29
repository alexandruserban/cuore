<?php
define('BASE_PATH', str_replace('\\', '/',dirname(__FILE__)) . '/');
define('CLASSNAME_SEPARATOR', '_');
define('ENVIRONMENT', 'dev');

/* light autoloader class PHP 5.3 required*/
spl_autoload_register(function ($class) {
    /* if your using namespaceing */
    $class = array_pop(explode('\\', preg_replace('/[^a-zA-Z0-9\_]/', '',$class)));
    
	$dir = strtolower(preg_replace(array('/([A-Z])/'), array('/$1'), $class));
	$file = BASE_PATH . substr($dir, 1) . '/' . $class . '.php';
    $dir_parts = explode('/', $dir);
    
	while (!file_exists($file) && count($dir_parts)) {
        array_pop($dir_parts);
        $file = BASE_PATH . substr(implode('/', $dir_parts), 1) . '/' . $class . '.php';
    }
    
    if (file_exists($file)) {
        require_once $file;
    } else {
        return false;
    }
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

CuoreRoute::$controller_prefix = SiteConfig::$core['controller_prefix'];
CuoreRoute::$default_controller = SiteConfig::$core['default_controller'];
CuoreRoute::$default_method   = SiteConfig::$core['default_method'];
CuoreRoute::init();
        
CuoreView::$cache_time = SiteConfig::$core['cache_time'];
CuoreView::$tpl_dir = SiteConfig::$dir['templates'];
CuoreView::$cache_dir = SiteConfig::$dir['cache'];
CuoreView::init();

CuoreLog::$dir = SiteConfig::$dir['log'];
CuoreLog::$file = SiteConfig::$file['log'];
CuoreLog::init();

CuoreDb::connect(CuoreConfig::$db['host'], CuoreConfig::$db['user'], CuoreConfig::$db['pass'], CuoreConfig::$db['db']);

CuoreConsole::$model_prefix = SiteConfig::$core['model_prefix'];
CuoreConsole::$model_dir = SiteConfig::$dir['model'];

if (!defined('CONSOLE')) {
    $parts = explode('/', SiteConfig::$url['base']);
    try {
        CuoreRoute::route(preg_replace('/[\/]+/','/',str_replace($parts, array_fill(0, count($parts), ''),
                                        $_SERVER['REQUEST_URI'])));
    } catch (CuoreException $e) {
        echo $e->getMessage();
    }
}