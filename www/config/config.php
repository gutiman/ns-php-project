<?php
 
/*
    The important thing to realize is that the config file should be included in every
    page of your project, or at least any page you want access to these settings.
    This allows you to confidently use these settings throughout a project because
    if something changes such as your database credentials, or a path to a specific resource,
    you'll only need to update it here.
*/
 
$config = array(
    "db" => array(
        "dbname" => "sqlite3",
        "file_path" => "../../sqlite3/lookup.db"
    ),
    "urls" => array(
        "baseUrl" => "http://192.168.100.122/"
    ),
    "paths" => array(
        "images" => $_SERVER["DOCUMENT_ROOT"] . "/imgs/"
    )
);
 
/*
    Creating constants for heavily used paths makes things a lot easier.
    ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
defined('DECORATORS_PATH') or define('DECORATORS_PATH', $_SERVER['DOCUMENT_ROOT'] . '/decorators');
defined('MODEL_PATH') or define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/model');
defined('CONTROLLERS_PATH') or define('CONTROLLERS_PATH', $_SERVER['DOCUMENT_ROOT'] . '/controllers');
defined('TEMPLATES_PATH') or define('TEMPLATES_PATH', $_SERVER['DOCUMENT_ROOT'] . '/views');
 
/*
    Error reporting.
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);