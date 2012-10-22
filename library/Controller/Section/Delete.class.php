<?php
/**
 * Delete a section.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_SectionDelete extends Model_Notice
{
    /**
     * Update the settings.
     *
     * Array(
     *     'user'        => Model_User,
     *     'settings'    => Model_Settings,
     *     'book'        => Model_Book,
     *
     *     'section_id'  => 123
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
                   s.section_id      = :section_id
            LIMIT  1
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id'         => $param['book']->getInfo('book_id'),
            ':section_id'      => $param['section_id'],
            ':section_removed' => $_SERVER['REQUEST_TIME']
        ));
    }
}