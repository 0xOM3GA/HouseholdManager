<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//define('_CONFIG', __DIR__.'/'); // /www_external/development/LocalSpaces/config/
//define('_ROOT', str_replace('/www_external', '', dirname(__DIR__, 1))); // /www_external/development/LocalSpaces    levels bewirkt 1 VZ hoch
define("_ROOT", dirname(__DIR__, 1)); // /www_external/development/LocalSpaces    levels bewirkt 1 VZ hoch

define('_CLASSES', _ROOT.'/classes');
define('_LOGS', _ROOT.'/logs');

define('_WEBROOT', _ROOT.'/public');
define('_AJAX', _WEBROOT.'/ajax');
define('_ASSETS', _WEBROOT.'/assets');
define('_CSS', _ASSETS.'/css');
define('_JS', _ASSETS.'/js');
define('_FONTS', _ASSETS.'/fonts');
define('_IMG', _ASSETS.'/img');

define('DB_KIND', 'mysql');
define('DB_HOST', '');
define('DB_PORT', '3306');
define('DB_HM', 'household_manager');
define('DB_HM_MASTER_DATA', 'household_manager_master_data');
define('DB_HM_LOG', 'household_manager_log');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8mb4_unicode_ci');
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
]);

define('FAVICON', 'https://picsum.photos/200');
define('DEFAULT_LANGUAGE', 'de_DE');