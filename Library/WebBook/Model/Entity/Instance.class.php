<?php
namespace WebBook\Model\Entity;
use WebBook\Model\Section;

/**
 * Contains information on an entity.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Instance extends Repository
{

	/**
	 * Sets up the entity, allowing it to contain one or many Entity\Instance's.
	 *
	 * @access public
	 * @param  array  $data All of the information on this entity.
	 */
	public function __construct($data = array()) {
		// Set up the collection
		$this->import($data);
	}
}