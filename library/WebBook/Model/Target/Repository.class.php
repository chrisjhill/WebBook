<?php
namespace WebBook\Model\Target;
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
	 * @access public
	 * @return mixed
	 */
	public function save() {
		return $this->update();
	}

	/**
	 * Update a single record.
	 *
	 * @access public
	 * @return boolean
	 */
	public function update() {
		$query = Model\Database::get()->prepare("
			UPDATE `target` t
			SET	   t.target_word_count = :target_word_count,
				   t.target_date       = :target_date
			WHERE  t.book_id           = :book_id
			LIMIT  1
		");

		// And execute query
		return $query->execute(array(
			':target_word_count' => $this->target_word_count,
			':target_date'       => $this->target_date,
			':book_id'           => $this->book_id
		));
	}

	/**
	 * Get the targets the user has set.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function get() {
		$query = Model\Database::get()->prepare("
			SELECT *
			FROM   `target` t
			WHERE  t.book_id = :book_id
			LIMIT  1
		");

		// And execute query
		$query->execute(array(':book_id' => $this->book_id));

		return $query->fetch();
	}
}