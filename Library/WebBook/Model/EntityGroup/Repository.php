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
}