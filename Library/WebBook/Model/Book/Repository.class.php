<?php
namespace WebBook\Model\Book;
use Core, WebBook\Model;

/**
 * The middle ground between the database and the model.
 *
 * The repository is essentially an ORM, but simplified.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Repository extends Core\Repository
{
	/**
	 * Saves a record to the database.
	 *
	 * This function handles both uppdate and save for an easier Model. If
	 * there is an ID in the store then we update, otherwise we insert.
	 *
	 * @access public
	 * @return mixed
	 */
	public function save() {
		return ! $this->has('book_id')
			? $this->insert()
			: $this->update();
	}

	/**
	 * Updates the book.
	 *
	 * @access public
	 */
	public function update() {
		$query = Model\Database::get()->prepare("
			UPDATE `book` b
			SET     b.book_title        = :book_title,
			        b.book_distribution = :book_distribution,
			        b.book_updated      = :book_updated
			WHERE   b.book_id           = :book_id
			LIMIT   1
		");

		// And execute query
		return $query->execute(array(
			':book_title'        => $this->book_title,
			':book_distribution' => $this->book_distribution,
			':book_updated'      => $this->book_updated,
			':book_id'           => $this->book_id
		));
	}

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
	 * Get the book information.
	 *
	 * @access public
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function get() {
		$query = Model\Database::get()->prepare("
			SELECT *
			FROM   `book` b
			WHERE  b.book_id = :book_id
			LIMIT  1
		");

		// And execute query
		$query->execute(array(':book_id' => $this->book_id));

		return $query->fetch();
	}

	/**
	 * Get all the sections in this book.
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

	/**
	 * Get all the sections for a snapshot.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function getAllSectionsFromSnapshot() {
		$query = Model\Database::get()->prepare("
			SELECT   *
			FROM     `snapshot` s
			WHERE    s.book_id          = :book_id
			         AND
			         s.snapshot_created = :snapshot_created
			ORDER BY s.chapter_id,
			         s.section_order,
			         s.section_id
		");

		// And execute query
		$query->execute(array(
			':book_id'          => $this->book_id,
			':snapshot_created' => $this->snapshot_created
		));

		return $query;
	}
}