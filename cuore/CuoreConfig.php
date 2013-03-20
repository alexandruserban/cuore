<?php

class CuoreConfig {

    static public $path;
    static public $url;
    static public $db;
    static public $core;

    function init() {
        /* user paths */
        self::$path['base'] = BASE_PATH;
        self::$path['pub'] = self::$path['base'] . 'pub/';
        self::$path['js'] = self::$path['pub'] . 'js/';
        self::$path['css'] = self::$path['pub'] . 'css/';
        self::$path['images'] = self::$path['pub'] . 'images/';
        self::$path['templates'] = self::$path['base'] . 'templates/';
        self::$path['tmp_cache_path'] = self::$path['base'] . 'cache/';
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
        self::$core['log_file_path'] = self::$path['base'] . 'logs/log.txt';
        self::$core['models_dir'] = self::$path['base'] . 'model/';
        self::$core['model_prefix'] = 'Model';
        self::$core['cache_time'] = 3600;
    }

}

?>