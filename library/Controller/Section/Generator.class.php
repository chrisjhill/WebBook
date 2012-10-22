<?php
/**
 * Return a complete HTML representation of a section.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Section_Generator
{
    public function generate($sectionType, $sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly = false) {
        // What section is this?
        switch ($sectionType) {
            // The book title
            case 'booktitle' :
                return Controller_Section_Generator::generateBookTitle($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly); break;
            // The book author
            case 'author' :
                return Controller_Section_Generator::generateBookAuthor($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly); break;
            // A chapter title
            case 'title' :
                return Controller_Section_Generator::generateChapterTitle($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly); break;
            // A subtitle
            case 'subtitle' :
                return Controller_Section_Generator::generateSubtitle($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly); break;
            // A section of content
            case 'content' :
                return Controller_Section_Generator::generateContent($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly); break;
        }
    }
    
    public function generateBookTitle($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly = false) {
        return '<p class="section book-title" '
                    . 'id="section-' . (int)$sectionId . '" '
                    . 'data-sectionid="' . (int)$sectionId . '" '
                    . 'data-chapterid="' . (int)$chapterId . '" '
                    . 'data-order="' . (int)$sectionOrder . '" '
                    . 'data-wordcount="' . (int)$wordCount . '" '
                    . 'name="cover" '
                    . (! $readonly ? 'contenteditable="true"' : '') . '>'
                        . $sectionContent
                    . '</p>';
    }
    
    public function generateBookAuthor($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly = false) {
        return '<p class="book-author">'
                    . '<span class="section" '
                    . 'id="section-' . (int)$sectionId . '" '
                    . 'data-sectionid="' . (int)$sectionId . '" '
                    . 'data-chapterid="' . (int)$chapterId . '" '
                    . 'data-order="' . (int)$sectionOrder . '" '
                    . 'data-wordcount="' . (int)$wordCount . '" '
                    . (! $readonly ? 'contenteditable="true"' : '') . '>'
                        . $sectionContent
                    . '</span></p>';
    }
    
    public function generateChapterTitle($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly = false) {
        return '<h2 class="section chapter-title title" '
                    . 'id="section-' . (int)$sectionId . '" '
                    . 'data-sectionid="' . (int)$sectionId . '" '
                    . 'data-chapterid="' . (int)$chapterId . '" '
                    . 'data-order="' . (int)$sectionOrder . '" '
                    . 'data-wordcount="' . (int)$wordCount . '" '
                    . (! $readonly ? 'contenteditable="true"' : '') . '>'
                        . $sectionContent
                    . '</h2>';
    }
    
    public function generateSubtitle($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly = false) {
        return '<h3 class="section title" '
                    . 'id="section-' . (int)$sectionId . '" '
                    . 'data-sectionid="' . (int)$sectionId . '" '
                    . 'data-chapterid="' . (int)$chapterId . '" '
                    . 'data-order="' . (int)$sectionOrder . '" '
                    . 'data-wordcount="' . (int)$wordCount . '" '
                    . (! $readonly ? 'contenteditable="true"' : '') . '>'
                        . $sectionContent
                    . '</h3>';
    }
    
    public function generateContent($sectionId, $chapterId, $sectionOrder, $sectionContent, $wordCount, $readonly = false) {
        return '<div class="section content" '
                    . 'id="section-' . (int)$sectionId . '" '
                    . 'data-sectionid="' . (int)$sectionId . '" '
                    . 'data-chapterid="' . (int)$chapterId . '" '
                    . 'data-order="' . (int)$sectionOrder . '" '
                    . 'data-wordcount="' . (int)$wordCount . '" '
                    . (! $readonly ? 'contenteditable="true"' : '') . '>'
                        . $sectionContent
                    . '</div>';
    }
}