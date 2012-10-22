<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Save the section
$sectionUpdate = new Controller_Section_Update();
echo $sectionUpdate->update(array(
    'user'               => $user,
    'settings'           => $settings,
    'book'               => $book,

    'section_id'         => $_POST['section_id'],
    'section_order'      => $_POST['section_order'],
    'section_content'    => $_POST['section_content'],
    'section_word_count' => $_POST['section_word_count']
));