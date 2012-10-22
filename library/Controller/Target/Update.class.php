<?php
/**
 * Update the target.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Target_Update extends Model_Notice
{
    /**
     * Update the target.
     *
     * Array(
     *     'user'              => Model_User,
     *     'settings'          => Model_Settings,
     *     'book'              => Model_Book,
     *
     *     'target_word_count' => 1 or 0,
     *     'target_date'       => 'PALATINO'
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
            UPDATE `target` s
            SET    s.target_word_count = :target_word_count,
                   s.target_date       = :target_date
            WHERE  s.book_id           = :book_id
            LIMIT  1
        ");
        
        // And execute query
        $query->execute(array(
            ':target_word_count' => $param['target_word_count'],
            ':target_date'       => $param['target_date'],

            ':book_id'           => $param['book']->getInfo('book_id')
        ));
    }
}