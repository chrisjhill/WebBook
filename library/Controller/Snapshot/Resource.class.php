<?php
/**
 * Return a resource of snapshots.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Snapshot_Resource extends Model_Notice
{
    /**
     * Return a resource of snapshots.
     *
     * @param array $bookId
     * @return Model_Resource
     */
    public function generate($bookId) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            SELECT   DISTINCT(s.snapshot_created) as 'snapshot_created'
            FROM     `snapshot` s
            WHERE    s.book_id = :book_id
            ORDER BY `snapshot_created`
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id' => $bookId
        ));
        
        // And return
        return $query;
    }
}