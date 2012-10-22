<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Create the chapter insertion class
$chapterInsert = new Controller_Chapter_Insert();

// Insert the start of the chapter
echo '
<div class="chapter"
    id="chapter-' . (int)$_POST['chapter_id'] . '"
    name="chapter-' . (int)$_POST['chapter_id'] . '"
    data-chapterid="' . (int)$_POST['chapter_id'] . '">
        <img src="/public/images/icon-cross.png" class="chapter-delete" alt="" />
    
    ' .
    $chapterInsert->insert(array(
        'user'       => $user,
        'settings'   => $settings,
        'book'       => $book,
    
        'chapter_id' => $_POST['chapter_id']
    ))
    . '

    <div class="chapter-insert"><a href="#">new chapter +</a></div>
</div>';