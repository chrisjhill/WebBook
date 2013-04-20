<?php
namespace WebBook\Model\Entity;
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
	 * Saves a record to the database.
	 *
	 * This function handles both uppdate and save for an easier Model. If
	 * there is an ID in the store then we update, otherwise we insert.
	 *
	 * @access public
	 * @return mixed
	 */
	public function save() {
		return ! $this->has('entity_id')
			? $this->insert()
			: $this->update();
	}

	/**
	 * Insert an entity into the database.
	 *
	 * @access public
	 * @return mixed  False is failure, integer of new record ID if success.
	 */
	public function insert() {
		// Insert a new entity
		$query = Model\Database::get()->prepare("
			INSERT INTO `entity` (
				`book_id`,
				`entity_group_id`,
				`entity_type`,
				`entity_title`,
				`entity_image`,
				`entity_content`,
				`entity_created`
			) VALUES (
				:book_id,
				:entity_group_id,
				:entity_type,
				:entity_title,
				:entity_image,
				:entity_content,
				:entity_created
			)
		");

		// And execute query
		$query->execute(array(
			':book_id'         => $this->book_id,
			':entity_group_id' => $this->entity_group_id,
			':entity_type'     => $this->entity_type,
			':entity_title'    => $this->entity_title,
			':entity_image'    => $this->entity_image,
			':entity_content'  => $this->entity_content,
			':entity_created'  => $this->entity_created
		));

		// Assign the section ID to this section
		$this->entity_id = Model\Database::get()->lastInsertId();
	}

	/**
	 * Update a single entity.
	 *
	 * @access public
	 * @return boolean
	 */
	public function update() {
		$query = Model\Database::get()->prepare("
			UPDATE `entity` e
			SET    e.entity_title    = :entity_title,
			       e.entity_image    = :entity_image,
			       e.entity_content  = :entity_content,
			       e.entity_updated  = :entity_updated
			WHERE  e.book_id         = :book_id
			       AND
			       e.entity_id       = :entity_id
			LIMIT  1
		");

		// And execute query
		return $query->execute(array(
			':entity_title'   => $this->entity_title,
			':entity_image'   => $this->entity_image,
			':entity_content' => $this->entity_content,
			':entity_updated' => $this->entity_updated,
			':book_id'        => $this->book_id,
			':entity_id'      => $this->entity_id
		));
	}

	/**
	 * Delete an entity.
	 *
	 * @access public
	 * @return boolean
	 */
	public function delete() {
		$query = Model\Database::get()->prepare("
			UPDATE `entity` e
			SET    e.entity_removed = :entity_removed
			WHERE  e.book_id        = :book_id
			       AND
			       e.entity_id      = :entity_id
		");

		// And execute query
		return $query->execute(array(
			':entity_removed' => $this->entity_removed,
			':book_id'        => $this->book_id,
			':entity_id'      => $this->entity_id
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
			FROM   `entity` e
			WHERE  e.book_id        = :book_id
			       AND
			       e.entity_id      = :entity_id
			       AND
			       e.entity_removed = 0
		");

		// And execute query
		$query->execute(array(
			':chapter_id' => $this->chapter_id,
			':entity_id'  => $this->entity_id,
			':book_id'    => $this->book_id
		));

		return $query;
	}
}