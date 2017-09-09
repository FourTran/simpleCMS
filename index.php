<?php
if (ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
$security_check = 1;

// define configurations
$config = require_once('config.php');
// define root folder
define('ROOT', $config['root']);
// define database
$database_config = $config['connection'][$config['database']];
$driver = $database_config['driver'];
define('DATABASE', ucfirst($driver).'Database');
define('DATABASE_NAME', $database_config['database']);
define('DATABASE_USER', $database_config['username']);
define('DATABASE_PASS', $database_config['password']);
define('DATABASE_SERVER', $database_config['host']);
// register apps
$GLOBALS['APPS'] = $config['apps'];
// define production secret key
define('SECRET', $config['secret']);

session_start();
if(isset($_SESSION['CSRF'])!== true)
{
    // all character which can be in random string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 32; $i++) {
        // choosing one character from all characters and adding it to random string
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
        // store generated csrf token using sha512 hashing
    $_SESSION['CSRF'] = hash('sha512',time().''.$randomString);
}
// make CSRF as constant for using in templates
define('CSRF', $_SESSION['CSRF']);
// if request is not GET then verify csrf_token
if($_SERVER['REQUEST_METHOD']!=='GET')
{
    if(!isset($_REQUEST['csrf_token']) || $_REQUEST['csrf_token'] !== $_SESSION['CSRF'])
    {
                // if wrong csrf_token stop user from accessing
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
}