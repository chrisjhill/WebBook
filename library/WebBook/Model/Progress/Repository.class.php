<?php
namespace WebBook\Model\Progress;
use Core, WebBook\Model;

/**
 * The middle ground between the database and the model.
 *
 * The repository is essentially an ORM, but simplified.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @since     16/03/2013
 */
class Repository extends Core\Repository
{
	/**
	 * Get the progression markers.
	 *
	 * @access public
	 * @param  int    $limit How many progressions to return.
	 * @return mixed         Array on success, false on failure.
	 */
	public function get($limit = 365) {
		$query = Model\Database::get()->prepare("
			SELECT *
			FROM   `progress` p
			WHERE  p.book_id = :book_id
			LIMIT  " . (int)$limit . "
		");

		// And execute query
		$query->execute(array(
			':book_id' => $this->book_id
		));

		return $query;
	}
}