<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Save the distribution
$distributionUpdate = new Controller_Distribution_Update();
echo $distributionUpdate->update(array(
    'user'              => $user,
    'settings'          => $settings,
    'book'              => $book,

    'book_distribution' => $_POST['book_distribution']
));