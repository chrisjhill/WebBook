<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Insert the section
$sectionInsert = new Controller_Section_Insert();
$sectionId = $sectionInsert->insert(array(
    'user'               => $user,
    'settings'           => $settings,
    'book'               => $book,

    'section_type'       => $_POST['section_type'],
    'chapter_id'         => $_POST['chapter_id'],
    'section_order'      => $_POST['section_order'],
    'section_content'    => '<p>Start typing&hellip;</p>',
    'section_word_count' => 2
));

// Which function do we need to call?
if ($_POST['section_type'] == 'subtitle') {
    $generate = 'generateSubtitle';
} else {
    $generate = 'generateContent';
}

// Return the HTML
echo $sectionId . '||' . Controller_Section_Generator::$generate(
    $sectionId,
    $_POST['chapter_id'],
    $_POST['section_order'],
    '<p>Start typing&hellip;</p>',
    2
);