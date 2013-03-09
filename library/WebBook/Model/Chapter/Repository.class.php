<?php
namespace WebBook\Model\Chapter;
use Core, WebBook\Model;

/**
 * The middle ground between the database and the model.
 *
 * The repository is essentially an ORM, but simplified.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     20/01/2013
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
			UPDATE `section` s
			SET    s.section_removed = :section_removed
			WHERE  s.book_id         = :book_id
			       AND
			       s.chapter_id	     = :chapter_id
		");

		// And execute query
		return $query->execute(array(
			':section_removed' => $this->section_removed,
			':book_id'         => $this->book_id,
			':chapter_id'      => $this->chapter_id
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
			SELECT *
			FROM   `section` s
			WHERE  s.book_id         = :book_id
			       AND
			       s.chapter_id      = :chapter_id
			       AND
			       s.section_removed = 0
		");

		// And execute query
		$query->execute(array(
			':chapter_id' => $this->chapter_id,
			':book_id'    => $this->book_id
		));

		return $query;
	}

	/**
	 * Update the order of chapters after inserting a chapter.
	 *
	 * @access public
	 */
	public function incrementOrder() {
		$query = Model\Database::get()->prepare("
			UPDATE `section` s
			SET    s.chapter_id  = s.chapter_id + 1
			WHERE  s.book_id     = :book_id
			       AND
			       s.chapter_id >= :chapter_id
		");

		// And execute query
		$query->execute(array(
			':book_id'    => $this->book_id,
			':chapter_id' => $this->chapter_id
		));
	}
}