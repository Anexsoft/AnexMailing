<?php
require_once 'vendor/autoload.php'; /* Composer */

/* Configuration Start */
require_once 'config.php';

$config = Config::get();
date_default_timezone_set($config->timezone);

ini_set('memory_limit', '-1');

$base_url = 'http://localhost/'; /* Base project URL */
if (isset($_SERVER['HTTP_HOST']))
{
    $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
    $base_url .= '://'. $_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
}

define('_BASE_HTTP_', $base_url);
define('_ADMIN_HTTP_', $base_url . 'admin');
define('_BASE_PATH_', __DIR__ . '/');
define('_LOG_PATH_', __DIR__ . '/log/');
define('_APP_PATH_', __DIR__ . '/app/');

if($config->environment === 'stop') {
    exit('Website is current down ..');
}
if($config->environment === 'prod') {
    error_reporting(0);
}
/* Configuration End */

require_once 'core/loader.php'; /* Load all */

use Core\Router; /* Namespaces */

Router::initialize(); /* Initialize Router */
