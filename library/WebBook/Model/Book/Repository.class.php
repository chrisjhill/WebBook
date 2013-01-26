<?php
namespace WebBook\Model\Book;
use Core, WebBook\Model;

/**
 * The middle ground between the database and the model.
 *
 * The repository is essentially an ORM, but simplified.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     23/01/2013
 */
class Repository extends Core\Repository
{
	/**
	 * Delete a chapter from a book.
	 *
	 * @access public
	 * @return boolean
	 */
	public function delete() {
		$query = Model\Database::get()->prepare("
			UPDATE `book` b
			SET    b.book_removed = :book_removed
			WHERE  b.book_id      = :book_id
		");

		// And execute query
		return $query->execute(array(
			':book_removed' => $this->book_removed,
			':book_id'      => $this->book_id
		));
	}

	/**
	 * Get all the records in a chapter.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function getAllSections() {
		$query = Model\Database::get()->prepare("
			SELECT   *
			FROM     `section` s
			WHERE    s.book_id         = :book_id
			         AND
			         s.section_removed = 0
			ORDER BY s.chapter_id,
			         s.section_order,
			         s.section_id
		");

		// And execute query
		$query->execute(array(
			':book_id'    => $this->book_id
		));

		return $query;
	}
}