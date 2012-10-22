<?php
/**
 * Insert a section.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_SectionInsert
{
    /**
     * Update the settings.
     *
     * Array(
     *     'user'               => Model_User,
     *     'settings'           => Model_Settings,
     *     'book'               => Model_Book,
     *
     *     'section_type'       => booktitle, bookauthor, title, subtitle, content
     *     'chapter_id'         => 123,
     *     'section_order'      => 456,
     *     'section_content'    => 'abc',
     *     'section_word_count' => 789
     * )     
     *
     * @param array $param
     * @param boolean $updateOrder
     * @return int
     */
    public function insert($param, $updateOrder = true) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // First, we need to increment all of the orders where this one fits in
        $this->updateOldOrder($pdo, $param);
        
        // Set query string
        $query = $pdo->prepare("
            INSERT INTO `section`
                (
                    `book_id`,
                    `chapter_id`,
                    `section_order`,
                    `section_type`,
                    `section_content`,
                    `section_word_count`,
                    `section_created`
                )
            VALUES
                (
                    :book_id,
                    :chapter_id,
                    :section_order,
                    :section_type,
                    :section_content,
                    :section_word_count,
                    :section_created
                )
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id'            => $param['book']->getInfo('book_id'),
            ':chapter_id'         => $param['chapter_id'],
            ':section_order'      => $param['section_order'],
            ':section_type'       => $param['section_type'],
            ':section_content'    => $param['section_content'],
            ':section_word_count' => $param['section_word_count'],
            ':section_created'    => $_SERVER['REQUEST_TIME']
        ));
        
        // And return the section ID
        return $pdo->lastInsertId();
    }
    
    
    private function updateOldOrder($pdo, $param) {
        // Set query string
        $query = $pdo->prepare("
            UPDATE `section` s
            SET    s.section_order = s.section_order + 1
            WHERE  s.book_id        = :book_id
                   AND
                   s.chapter_id     = :chapter_id
                   AND
                   s.section_order >= :section_order
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id'            => $param['book']->getInfo('book_id'),
            ':chapter_id'         => $param['chapter_id'],
            ':section_order'      => $param['section_order']
        ));
    }
}