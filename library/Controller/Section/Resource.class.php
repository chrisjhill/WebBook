<?php
/**
 * Return a resource of sections.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Controller_Section_Resource extends Model_Notice
{
    /**
     * Return a resource of sections.
     *
     * @param array $params
     * @param int $chapterId
     * @return Model_Resource
     */
    public function generate($bookId, $chapterId = 0) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            SELECT   s.section_id, s.book_id, s.chapter_id, s.section_order,
                     s.section_type, s.section_content, s.section_word_count,
                     s.section_created, s.section_updated, s.section_removed
            FROM     `section` s
            WHERE    s.book_id         = :book_id
                     AND
                     s.section_removed = 0
            ORDER BY s.chapter_id, s.section_order
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id' => $bookId
        ));
        
        // And return
        return $query;
    }
    
    /**
     * Return a resource of sections.
     *
     * @param array $params
     * @param int $chapterId
     * @param int $snapshotId
     * @return Model_Resource
     */
    public function generateSnapshot($bookId, $chapterId = 0, $snapshotId) {
        // Get PDO
        $pdo = Model_Database::getPdoConnection();
        
        // Set query string
        $query = $pdo->prepare("
            SELECT   s.book_id, s.chapter_id, s.section_id, s.section_order, s.section_type, s.section_content, s.snapshot_created,
                     0 AS 'section_word_count'
            FROM     `snapshot` s
            WHERE    s.book_id          = :book_id
                     AND
                     s.snapshot_created = :snapshot_id
            ORDER BY s.chapter_id, s.section_order
        ");
        
        // And execute query
        $query->execute(array(
            ':book_id'     => $bookId,
            ':snapshot_id' => $snapshotId
        ));
        
        // And return
        return $query;
    }
}