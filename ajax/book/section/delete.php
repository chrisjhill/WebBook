<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Delete the section
$sectionDelete = new Controller_Section_Delete();
$sectionDelete->delete(array(
    'user'       => $user,
    'settings'   => $settings,
    'book'       => $book,

    'section_id' => $_POST['section_id']
));