<?php
/**
 * Delete a snapshot.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Snapshot_Delete extends Model_Notice
{
    /**
     * Update the settings.
     *
     * Array(
     *     'user'        => Model_User,
     *     'settings'    => Model_Settings,
     *     'book'        => Model_Book,
     *
     *     'snapshot_id' => 123
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
            DELETE FROM `snapshot`
            WHERE       `book_id`          = :book_id
                        AND
                        `snapshot_created` = :snapshot_id
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id'     => $param['book']->getInfo('book_id'),
            ':snapshot_id' => $param['snapshot_id']
        ));
    }
}