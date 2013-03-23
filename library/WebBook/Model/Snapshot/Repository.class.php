<?php
namespace WebBook\Model\Snapshot;
use Core, WebBook\Model;

/**
 * The middle ground between the database and the model.
 *
 * The repository is essentially an ORM, but simplified.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Repository extends Core\Repository
{
	/**
	 * Save a snapshot.
	 *
	 * @access public
	 * @return mixed
	 */
	public function save() {
		return $this->insert();
	}

	/**
	 * Insert a snapshot.
	 *
	 * @access public
	 * @return boolean
	 */
	public function insert() {
		// Insert the new section
		$query = Model\Database::get()->prepare("
			INSERT INTO `snapshot` (
				`book_id`,
				`chapter_id`,
				`section_order`,
				`section_type`,
				`section_content`,
				`snapshot_created`
			) VALUES (
				:book_id,
				:chapter_id,
				:section_order,
				:section_type,
				:section_content,
				:snapshot_created
			)
		");

		// Loop over the sections and insert
		foreach ($this->book as $chapterId => $chapter) {
			foreach ($chapter as $section) {
				// And execute query
				$query->execute(array(
					':book_id'          => $section->book_id,
					':chapter_id'       => $section->chapter_id,
					':section_order'    => $section->section_order,
					':section_type'     => $section->section_type,
					':section_content'  => $section->section_content,
					':snapshot_created' => $this->snapshot_created
				));
			}
		}
	}

	/**
	 * Delete a snapshot.
	 *
	 * @access public
	 * @return boolean
	 */
	public function delete() {
		$query = Model\Database::get()->prepare("
			DELETE FROM `snapshot`
			WHERE  `book_id`          = :book_id
			       AND
			       `snapshot_created` = :snapshot_created
		");

		// And execute query
		return $query->execute(array(
			':book_id'          => $this->book_id,
			':snapshot_created' => $this->snapshot_created
		));
	}

	/**
	 * Get all the records in a chapter.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function get() {
		$query = Model\Database::get()->prepare("
			SELECT DISTINCT(s.snapshot_created) as 'snapshot_created'
			FROM   `snapshot` s
			WHERE  s.book_id = :book_id
		");

		// And execute query
		$query->execute(array(
			':book_id' => $this->book_id
		));

		return $query;
	}
}