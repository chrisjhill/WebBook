<?php
/**
 * Update the section.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_SectionUpdate extends Model_Notice
{
    /**
     * Update the settings.
     *
     * Array(
     *     'user'               => Model_User,
     *     'settings'           => Model_Settings,
     *     'book'               => Model_Book,
     *
     *     'section_id'         => 123,
     *     'section_order'      => 123,
     *     'section_content'    => 'abc',
     *     'section_word_count' => 456
     * )     
     *
     * @param array $param
     * @return boolean
     */
    public function update($param) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            UPDATE `section` s
            SET    s.section_order      = :section_order,
                   s.section_content    = :section_content,
                   s.section_word_count = :section_word_count,
                   s.section_updated    = :section_updated
            WHERE  s.book_id            = :book_id
                   AND
                   s.section_id         = :section_id
            LIMIT  1
        ");
        
        // And execute query
        $query->execute(array(
            ':section_order'      => $param['section_order'],
            ':section_content'    => $param['section_content'],
            ':section_word_count' => $param['section_word_count'],
            ':section_updated'    => $_SERVER['REQUEST_TIME'],

            ':book_id'            => $param['book']->getInfo('book_id'),
            ':section_id'         => $param['section_id']
        ));
    }
}