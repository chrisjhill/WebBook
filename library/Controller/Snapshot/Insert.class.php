<?php
/**
 * Insert a snapshot.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Snapshot_Insert
{
    /**
     * Update the settings.
     *
     * Array(
     *     'user'     => Model_User,
     *     'settings' => Model_Settings,
     *     'book'     => Model_Book
     * )     
     *
     * @param array $param
     * @return int
     */
    public function insert($param) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Delete the old snapshot (if necessary) first
        $this->deleteOldSnapshot($pdo, $param);
        
        // Set query string
        $query = $pdo->prepare("
            SELECT s.section_id, s.book_id, s.chapter_id, s.section_order, s.section_type, s.section_content
            FROM   `section` s
            WHERE  s.book_id         = :book_id
                   AND
                   s.section_removed = 0
        ");
        
        // And execute
        $query->execute(array(
            ':book_id' => $param['book']->getInfo('book_id')
        ));
        
        // Create the insert statement
        $insert = $pdo->prepare("
            INSERT INTO `snapshot`
                (
                    `book_id`,
                    `chapter_id`,
                    `section_id`,
                    `section_order`,
                    `section_type`,
                    `section_content`,
                    `snapshot_created`
                )
            VALUES
                (
                    :book_id,
                    :chapter_id,
                    :section_id,
                    :section_order,
                    :section_type,
                    :section_content,
                    :snapshot_created
                )
        ");
        
        // Loop over the snapshots and insert
        while ($section = $query->fetch()) {
            // And insert
            $insert->execute(array(
                ':book_id'          => $section['book_id'],
                ':chapter_id'       => $section['chapter_id'],
                ':section_id'       => $section['section_id'],
                ':section_order'    => $section['section_order'],
                ':section_type'     => $section['section_type'],
                ':section_content'  => $section['section_content'],
                ':snapshot_created' => $_SERVER['REQUEST_TIME']
            ));
        }
    }
    
    /**
     * Update the settings.
     *
     * Array(
     *     'user'     => Model_User,
     *     'settings' => Model_Settings,
     *     'book'     => Model_Book
     * )     
     *
     * @param PDO $pdo
     * @param array $param
     * @return int
     */
    public function deleteOldSnapshot($pdo, $param) {
        // Grab all of their current snapshots
        $snapshots = Controller_Snapshot_Resource::generate($param['book']->getInfo('book_id'));
        
        // Are there more than 5 snapshots already?
        if ($snapshots->rowCount() >= $param['user']->getInfo('plan_snapshot_limit')) {
            // Get the created timestamp of the fifth snapshot (starts at 0)
            $snapshotCreated = $snapshots->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT, 4);
            
            // Remove the fifth
            $query = $pdo->prepare("
                DELETE FROM `snapshot`
                WHERE       `snapshot_created` = :snapshot_created
            ");
            
            // And execute
            $query->execute(array(
                ':snapshot_created' => $snapshotCreated['snapshot_created']
            ));
        }
    }
}