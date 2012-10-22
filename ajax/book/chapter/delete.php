<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Delete the chapter
$chapterDelete = new Controller_Chapter_Delete();
$chapterDelete->delete(array(
    'user'       => $user,
    'settings'   => $settings,
    'book'       => $book,

    'chapter_id' => $_POST['chapter_id']
));