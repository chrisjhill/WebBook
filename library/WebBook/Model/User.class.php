<?php
namespace WebBook\Model;
use Core, WebBook\Model;

/**
 * Contains information on a single user.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     22/10/2012
 */
class User
{
	/**
	 * Information on the user.
	 *
	 * @access private
	 * @var    array
	 */
	private $_info = array();

	/**
	 * Initialise the user.
	 *
	 * @access public
	 * @param  int    $userId The ID of the user we wish to load.
	 */
	public function __construct($userId) {
		$this->setInfo($userId);
	}

	/**
	 * Get the book for a logged in user.
	 *
	 * @access private
	 * @param  int       $userId The ID of the user we wish to load.
	 * @throws Exception         If the user cannot be found.
	 */
	private function setInfo($userId) {
		// Set query string
		$query = Database::get()->prepare("
			SELECT u.user_id, u.user_name, u.user_email, u.user_password, u.user_created, u.user_updated, u.user_removed,
				   p.plan_id, p.plan_title, p.plan_book_limit, p.plan_snapshot_limit
			FROM   `user` u
					   LEFT JOIN `plan` p ON p.plan_id = u.plan_id
			WHERE  u.user_id = :user_id
			LIMIT  1
		");

		// And execute
		$query->execute(array(
			':user_id' => $userId
		));

		// Could we the user?
		if ($query->rowCount() <= 0) {
			throw new Exception('User not found.');
		}

		// Set all of the information
		$this->_info = $query->fetch();
	}

	/**
	 * Returns a piece of information on the user.
	 *
	 * @access public
	 * @param  string $variable The piece of data we want on the user.
	 * @param  string $default  If we cannot find the piece of data, this is returned.
	 * @return string
	 */
	public function getInfo($variable, $default = null) {
		return isset($this->_info[$variable])
			? $this->_info[$variable]
			: $default;
	}
}