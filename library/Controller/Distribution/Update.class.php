<?php
/**
 * Update the distribution.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Distribution_Update
{
    /**
     * Update the distribution.
     *
     * Array(
     *     'user'              => Model_User,
     *     'distribution'      => Model_distribution,
     *     'book'              => Model_Book,
     *
     *     'book_distribution' => 0, 1, or 2
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
            UPDATE `book` b
            SET    b.book_distribution = :book_distribution
            WHERE  b.book_id           = :book_id
            LIMIT  1
        ");
        
        // And execute query
        $query->execute(array(
            ':book_distribution' => $param['book_distribution'],
            ':book_id'           => $param['book']->getInfo('book_id')
        ));
    }
}