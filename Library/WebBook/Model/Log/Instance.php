<?php
namespace WebBook\Model\Log;

/**
 * Handles inserting a log into the database
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Instance extends Repository
{
	/**
	 * Create a new Section\Instance.
	 *
	 * @access public
	 * @param  array  $data All of the information on this log item.
	 */
	public function __construct($data = array()) {
		$this->import($data);
	}
}