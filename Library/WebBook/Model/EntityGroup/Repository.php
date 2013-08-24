<?php
namespace WebBook\Model\EntityGroup;
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
		return ! $this->has('entity_group_id')
			? $this->insert()
			: $this->update();
	}

	/**
	 * Insert an entity group into the database.
	 *
	 * @access public
	 * @return mixed  False is failure, integer of new record ID if success.
	 */
	public function insert() {
		// Get the new group ID
		$this->group_order = $this->getNextGroupOrder();

		// Insert a new entity
		$query = Model\Database::get()->prepare("
			INSERT INTO `entity_group` (
				`book_id`,
				`group_order`,
				`group_title`,
				`group_created`
			) VALUES (
				:book_id,
				:group_order,
				:group_title,
				:group_created
			)
		");

		// And execute query
		$query->execute(array(
			':book_id'       => $this->book_id,
			':group_order'   => $this->group_order,
			':group_title'   => $this->group_title,
			':group_created' => $this->group_created
		));

		// And return the ID of this new group
		return Model\Database::get()->lastInsertId();
	}

	/**
	 * Updates an entity group.
	 *
	 * @access public
	 * @return boolean
	 */
	public function update() {
		// Insert a new entity
		$query = Model\Database::get()->prepare("
			UPDATE `entity_group`
			SET    `group_title`     = :group_title,
			       `group_updated`   = :group_updated
			WHERE  `book_id`         = :book_id
			       AND
			       `entity_group_id` = :entity_group_id
		");

		// And execute query
		return $query->execute(array(
			':group_title'     => $this->group_title,
			':group_updated'   => $this->group_updated,
			':book_id'         => $this->book_id,
			':entity_group_id' => $this->entity_group_id
		));
	}

	/**
	 * Get all the entities in their group.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function get() {
		$query = Model\Database::get()->prepare("
			SELECT   e.*, g.group_title
			FROM     `entity` e
			             LEFT JOIN `entity_group` g ON
			                 g.entity_group_id = e.entity_group_id
			WHERE    e.book_id        = :book_id
			         AND
			         e.entity_type    = :entity_type
			         AND
			         e.entity_removed = 0
			ORDER BY g.group_order
		");

		// And execute query
		$query->execute(array(
			':book_id'     => $this->book_id,
			':entity_type' => $this->entity_type
		));

		return $query;
	}

	/**
	 * Only retrieves the entity group information, not its entities.
	 *
	 * @access public
	 * @return array
	 */
	public function getEntityGroup() {
		$query = Model\Database::get()->prepare("
			SELECT `entity_group_id`, `group_title`
			FROM   `entity_group`
			WHERE  `book_id`         = :book_id
			       AND
			       `entity_group_id` = :entity_group_id
			       AND
			       `group_removed`   = 0
			LIMIT   1
		");

		// And execute query
		$query->execute(array(
			':book_id'         => $this->book_id,
			':entity_group_id' => $this->entity_group_id
		));

		return $query->fetch();
	}

	/**
	 * Return the next available group order.
	 *
	 * @access private
	 * @return int
	 */
	private function getNextGroupOrder() {
		$query = Model\Database::get()->prepare("
			SELECT MAX(g.group_order) as 'max_group_order'
			FROM   `entity_group` g
			WHERE  g.book_id        = :book_id
			       AND
			       g.group_removed = 0
		");

		// And execute query
		$query->execute(array(
			':book_id'     => $this->book_id
		));

		// Fetch and return the next group order
		$query = $query->fetch();
		return ++$query['max_group_order'];
	}
}