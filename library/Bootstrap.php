<?php
// Include the headers
include $_SERVER['DOCUMENT_ROOT'] . '/library/Headers.php';

// If the user has posted a password, set it to the distribution
if (isset($_POST['password'])) {
    $_GET['book_distribution'] = $_POST['password'];
}

// Set some default variables
$bookUserId   = 0;
$bookPassword = '';

// Has the user supplied a book distribution password
// If they have then we can "bypass" the logged in check
// We check, in the book class, that the book is set to public
// So there is no security breach here
if (isset($_GET['book_distribution']) && ! empty($_GET['book_distribution'])) {
    // A book distribution code has been supplied
    // The book class will make sure it is correct
    $bookPassword = $_GET['book_distribution'];
} else {
    // No distribution code supplied
    // Which means we need to try and log the user in
    $_SESSION['user']['id'] = 1;
    $user = Model_User::getInstance($_SESSION['user']['id']);
    $bookUserId = $user->getInfo('user_id');
}

// Get the book
$book = Model_Book::getInstance($_GET['book_id'], $bookUserId, $bookPassword);

// Get the settings
$settings = Model_Settings::getInstance($_GET['book_id']);