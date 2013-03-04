<?php
namespace WebBook\Model\Section;
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
	 * Saves a record to the database.
	 *
	 * This function handles both uppdate and save for an easier Model. If
	 * there is an ID in the store then we update, otherwise we insert.
	 *
	 * @access public
	 * @return mixed
	 */
	public function save() {
		return ! $this->has('section_id')
			? $this->insert()
			: $this->update();
	}

	/**
	 * Insert a record into the database.
	 *
	 * @access public
	 * @return mixed  False is failure, integer of new record ID if success.
	 */
	public function insert() {
		$query = Model\Database::get()->prepare("
			INSERT INTO `section` (
				`book_id`,
				`chapter_id`,
				`section_order`,
				`section_type`,
				`section_content`,
				`section_word_count`,
				`section_created`
			) VALUES (
				:book_id,
				:chapter_id,
				:section_order,
				:section_type,
				:section_content,
				:section_word_count,
				:section_created
			)
		");

		// And execute query
		$query->execute(array(
			':book_id'            => $this->book_id,
			':chapter_id'         => $this->chapter_id,
			':section_order'      => $this->section_order,
			':section_type'       => $this->section_type,
			':section_content'    => $this->section_content,
			':section_word_count' => $this->section_word_count,
			':section_created'    => $this->section_created
		));

		return Model\Database::get()->lastInsertId();
	}

	/**
	 * Update a single record.
	 *
	 * @access public
	 * @return boolean
	 */
	public function update() {
		$query = Model\Database::get()->prepare("
			UPDATE `section` s
			SET    s.section_order      = :section_order,
			       s.section_content    = :section_content,
			       s.section_word_count = :section_word_count,
			       s.section_updated    = :section_updated
			WHERE  s.book_id            = :book_id
			       AND
			       s.section_id         = :section_id
			LIMIT  1
		");

		// And execute query
		return $query->execute(array(
			':section_order'      => $this->section_order,
			':section_content'    => $this->section_content,
			':section_word_count' => $this->section_word_count,
			':section_updated'    => $this->section_updated,
			':book_id'            => $this->book_id,
			':section_id'         => $this->section_id
		));
	}

	/**
	 * Delete a section from a chapter.
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
			       s.section_id      = :section_id
		");

		// And execute query
		return $query->execute(array(
			':book_id'         => $this->book_id,
			':section_id'      => $this->section_id,
			':section_removed' => $this->section_removed
		));
	}

	/**
	 * Get a single entity.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function get() {
		$query = Model\Database::get()->prepare("
			SELECT *
			FROM   `section` s
			WHERE  s.section_id      = :section_id
			       AND
			       s.section_removed = 0
			LIMIT  1
		");

		// And execute query
		$query->execute(array(':section_id' => $this->section_id));

		return $query->fetch();
	}

	/**
	 * Get all the records in a book.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function getAllInBook() {
		$query = Model\Database::get()->prepare("
			SELECT *
			FROM   `section` s
			WHERE  s.book_id         = :book_id
			       AND
			       s.section_removed = 0
		");

		// And execute query
		$query->execute(array(':book_id' => $this->book_id));

		return $query;
	}
}