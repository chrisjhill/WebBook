<?php
// Start session, buffer, content type and timezome
session_start();
ob_start();
header("Content-type:text/html; charset=utf-8");
putenv('TZ=Europe/London');

// Set error reporting
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Include the autoloader
include $_SERVER['DOCUMENT_ROOT'] . '/library/Autoload.function.php';