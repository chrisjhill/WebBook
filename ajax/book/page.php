<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Turn snapshot into variable
$_POST['readonly'] = $_POST['readonly'] == "true"
    ? true
    : false;

// Get the content sections
if ($_POST['snapshot_id'] >= 1) {
    // Get sections from a snapshot
    $sections = Controller_Section_Resource::generateSnapshot($book->getInfo('book_id'), 0, $_POST['snapshot_id']);
} else {
    // Get the latest files
    $sections = Controller_Section_Resource::generate($book->getInfo('book_id'));
}
?>

<div class="container">
    
    <?php
    // Set chapter
    $chapter = 0;
    
    // Loop over sections
    while ($section = $sections->fetch()) {
        // Is this a new chapter?
        if ($section['chapter_id'] !== $chapter) {
            // Start of a new chapter
            // Do we need to close the previous chapter?
            if ($chapter >= 1 && ! $_POST['readonly']) {
                echo '<div class="chapter-insert"><a href="#">new chapter +</a></div></div>';
            } else if ($chapter >= 1) {
                echo '</div>';
            }
            
            // Start of chapter
            echo '<div class="chapter"
                       id="chapter-' . (int)$section['chapter_id'] . '"
                       name="chapter-' . (int)$section['chapter_id'] . '"
                       data-chapterid="' . (int)$section['chapter_id'] . '">';
            
            // Is this not the first chapter?
            if ($chapter > 0 && $_POST['readonly']) {
                echo '<img src="/public/images/icon-cross.png" class="chapter-delete" alt="" />';
            }
            
            // Set the chapter
            $chapter = $section['chapter_id'];
        }
        
        // Echo out the section
        echo Controller_Section_Generator::generate(
            $section['section_type'],
            $section['section_id'],
            $section['chapter_id'],
            $section['section_order'],
            $section['section_content'],
            $section['section_word_count'],
            $_POST['readonly']
        );
    }
    
    // Close the last chapter
    if (! $_POST['readonly']) {
        echo '<div class="chapter-insert"><a href="#">new chapter +</a></div>';
    }
    echo '</div>';
    ?>
    
    <div id="section-insert">
        <p>
            <a href="#" class="section-insert-link" id="section-insert-title" data-sectionid="0">title +</a><br />
            <a href="#" class="section-insert-link" id="section-insert-content" data-sectionid="0">content +</a><br />
            <a href="#" class="section-insert-link" id="section-insert-delete" data-sectionid="0">delete &ndash;</a><br />
        </p>
    </div>
</div>