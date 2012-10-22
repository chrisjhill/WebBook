<?php
/**
 * Return a resource of targets.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Target_Resource extends Model_Notice
{
    /**
     * Return a resource of targets
     *
     * @param array $bookId
     * @return Model_Resource
     */
    public function generate($bookId) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            SELECT   t.book_id, t.target_word_count, t.target_date
            FROM     `target` t
            WHERE    t.book_id = :book_id
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id' => $bookId
        ));
        
        // And return
        return $query;
    }
}