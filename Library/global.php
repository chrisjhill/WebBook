<?php
// Start the session and object buffer
session_start();

// Include the autoloader
include dirname(__FILE__) . '/autoloader.php';
$loader = new SplClassLoader();
$loader->register();