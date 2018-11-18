<?php

session_start();
ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(-1);
use vendor\core\Router;

$query = trim($_SERVER['QUERY_STRING'], '/');

define('WWW',__DIR__);
define('ROOT',dirname(__DIR__));
define('CORE', dirname(__DIR__).'/vendor/core');
define('APP', dirname(__DIR__).'/app');
define('LAYOUT', 'default');

spl_autoload_register(function($class){
    $file = ROOT.'/'.str_replace('\\','/',$class).'.php';
    if(is_file($file)){
        require_once($file);
    }
});

Router::add('^product/(?P<index>[0-9]+)$', ['controller' => 'Product','action' => 'view']);
Router::add('^product/search/(?P<index>[0-9]+)$', ['controller' => 'Product','action' => 'search']);
Router::add('^$', ['controller' => 'Site', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);
