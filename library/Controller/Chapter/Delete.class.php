<?php
/**
 * Delete a chapter.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 *
 */

class Controller_Chapter_Delete extends Model_Notice
{
    /**
     * Delete a chapter.
     *
     * Array(
     *     'user'        => Model_User,
     *     'settings'    => Model_Settings,
     *     'book'        => Model_Book,
     *
     *     'chapter_id'  => 123
     * )     
     *
     * @param array $param
     * @return int
     */
    public function delete($param) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            UPDATE `section` s
            SET    s.section_removed = :section_removed
            WHERE  s.book_id         = :book_id
                   AND
                   s.chapter_id      = :chapter_id
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id'         => $param['book']->getInfo('book_id'),
            ':chapter_id'      => $param['chapter_id'],
            ':section_removed' => $_SERVER['REQUEST_TIME']
        ));
    }
}