<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Save a target
$targetUpdate = new Controller_Target_Update();
$targetUpdate->update(array(
    'user'              => $user,
    'settings'          => $settings,
    'book'              => $book,

    'target_word_count' => str_replace(array(' ', '.', ',', '-'), '', $_POST['target_word_count']),
    'target_date'       => strtotime($_POST['target_date'])
));
var_dump($_POST);