<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Global configurations
include dirname(__FILE__) . '/../Library/global.php';

// Start the router
new Core\Front('WebBook');