<?php
namespace WebBook\Model\Log;
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
		return $this->insert();
	}

	/**
	 * Update a single record.
	 *
	 * @access public
	 * @return boolean
	 */
	public function insert() {
		$query = Model\Database::get()->prepare("
			INSERT INTO `log` (
				`book_id`,
				`user_id`,
				`log_action`,
				`log_status`,
				`log_message`,
				`log_url`,
				`log_ip`,
				`log_user_agent`
			) VALUES (
				:book_id,
				:user_id,
				:log_action,
				:log_status,
				:log_message,
				:log_url,
				:log_ip,
				:log_user_agent
			)
		");

		// And execute query
		return $query->execute(array(
			':book_id'        => $this->book_id,
			':user_id'        => $this->user_id,
			':log_action'     => $this->log_action,
			':log_status'     => $this->log_status,
			':log_message'    => $this->log_message,
			':log_url'        => $this->log_url,
			':log_ip'         => $this->log_ip,
			':log_user_agent' => $this->log_user_agent
		));
	}
}