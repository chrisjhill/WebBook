<?php
namespace WebBook\Model\User;
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
	 * Get a single user.
	 *
	 * @access public
	 * @return mixed  Array on success, false on failure.
	 */
	public function get() {
		$query = Model\Database::get()->prepare("
			SELECT *
			FROM   `user` u
			WHERE  u.user_id = :user_id
			LIMIT  1
		");

		// And execute query
		$query->execute(array(':user_id' => $this->user_id));

		return $query->fetch();
	}
}