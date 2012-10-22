<?php
/**
 * Insert a chapter.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Chapter_Insert
{
    /**
     * Insert a chapter.
     *
     * Array(
     *     'user'               => Model_User,
     *     'settings'           => Model_Settings,
     *     'book'               => Model_Book,
     *
     *     'chapter_id'         => 123
     * )     
     *
     * @param array $param
     * @return int
     */
    public function insert($param) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // First, we need to increment all of the orders where this one fits in
        $this->updateOldOrder($pdo, $param);
        
        // Insert the chapter title
        $sectionInsert = new Controller_Section_Insert();
        $sectionTitleId = $sectionInsert->insert(array(
            'user'               => $param['user'],
            'settings'           => $param['settings'],
            'book'               => $param['book'],
        
            'section_type'       => 'title',
            'chapter_id'         => $param['chapter_id'],
            'section_order'      => 1,
            'section_content'    => 'Chapter title, start typing&hellip;',
            'section_word_count' => 4
        ), false);
        
        // Insert the chapter content
        $sectionContentId = $sectionInsert->insert(array(
            'user'               => $param['user'],
            'settings'           => $param['settings'],
            'book'               => $param['book'],
        
            'section_type'       => 'content',
            'chapter_id'         => $param['chapter_id'],
            'section_order'      => 2,
            'section_content'    => '<p>Press tab to start editing me.</p>',
            'section_word_count' => 6
        ), false);
        
        // And return the HTML
        return 
            Controller_SectionGenerator::generateChapterTitle(
                $sectionTitleId,
                $param['chapter_id'],
                1,
                'Chapter title, start typing&hellip;',
                4
            )
            .
            Controller_SectionGenerator::generateContent(
                $sectionContentId,
                $param['chapter_id'],
                2,
                '<p>Press tab to start editing me.</p>',
                6
            );
    }
    
    
    private function updateOldOrder($pdo, $param) {
        // Set query string
        $query = $pdo->prepare("
            UPDATE `section` s
            SET    s.chapter_id  = s.chapter_id + 1
            WHERE  s.book_id     = :book_id
                   AND
                   s.chapter_id >= :chapter_id
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id'            => $param['book']->getInfo('book_id'),
            ':chapter_id'         => $param['chapter_id']
        ));
    }
}