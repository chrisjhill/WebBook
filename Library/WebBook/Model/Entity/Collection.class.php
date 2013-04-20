<?php
namespace WebBook\Model\Entity;

/**
 * A list of entities in a book.
 *
 * @copyright   2013 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class Collection
{
	/**
	 * An array of the entities.
	 *
	 * @access public
	 * @var    array   An collection of Entity\Instance's
	 */
	public $store = array();

	/**
	 * Add an entity to this list.
	 *
	 * @access public
	 * @param  Entity\Instance $entity An entity to add.
	 * @throws Exception               If Entity\Instance is not passed in.
	 */
	public function add($entity) {
		if (get_class($entity) != 'WebBook\Model\Entity\Instance') {
			throw new \Exception('Expecting a Entity class.');
		}

		// And add to the store
		$this->store[$entity->entity_id] = $entity;
	}
}