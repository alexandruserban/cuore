<?php

class CuoreConfig {

    static public $dir;
    static public $url;
    static public $db;
    static public $core;
    static public $file;

    function init() {
        /* user paths */
        self::$dir['base'] = BASE_PATH;
        self::$dir['pub'] = self::$dir['base'] . 'pub/';
        self::$dir['js'] = self::$dir['pub'] . 'js/';
        self::$dir['css'] = self::$dir['pub'] . 'css/';
        self::$dir['images'] = self::$dir['pub'] . 'images/';
        self::$dir['templates'] = self::$dir['base'] . 'templates/';
        self::$dir['cache'] = self::$dir['base'] . 'cache/';
        self::$dir['log'] = self::$dir['base'] . 'logs/';
        self::$dir['model'] = self::$dir['base'] . 'model/';
        /* urls */
        self::$url['base'] = 'cuore.lo'; //$_SERVER['SERVER_NAME'];

        /* DB */
        self::$db['host'] = 'localhost';
        self::$db['user'] = 'user';
        self::$db['pass'] = 'pass';
        self::$db['db'] = 'user_db';

        /* framework config */
        self::$core['controller_prefix'] = 'Controller';
        self::$core['default_controller'] = 'Default';
        self::$core['default_method'] = 'main';
        self::$core['model_prefix'] = 'Model';
        self::$core['cache_time'] = 3600;
        
        /* files */
        self::$file['log'] = 'log.txt';
    }

}

?>