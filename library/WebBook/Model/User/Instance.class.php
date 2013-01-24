<?php
namespace WebBook\Model\User;
use Core, WebBook\Model;

/**
 * Contains information on a single user.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     22/10/2012
 */
class Instance extends Repository
{
	/**
	 * Get the information on a single user..
	 *
	 * @access public
	 * @param  int    $userId The user that we want to get.
	 */
	public function __construct($userId) {
		$this->user_id = $userId;
		$this->setData();
	}

	/**
	 * Get the user's data and import them into the store.
	 *
	 * @access public
	 */
	public function setData() {
		$this->import($this->get());
	}
}