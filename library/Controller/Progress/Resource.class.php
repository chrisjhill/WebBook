<?php
/**
 * Return a resource of progress.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Progress_Resource extends Model_Notice
{
    /**
     * Return a resource of progress
     *
     * @param array $bookId
     * @return Model_Resource
     */
    public function generate($bookId) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            SELECT   p.progress_word_count, p.progress_date
            FROM     `progress` p
            WHERE    p.book_id = :book_id
            ORDER BY p.progress_date ASC
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id' => $bookId
        ));
        
        // And return
        return $query;
    }
}