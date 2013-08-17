<?php
namespace WebBook\Model\EntityGroup;
use WebBook\Model\Entity;

/**
 * Contains information on an entity.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Instance extends Repository implements \IteratorAggregate
{
	/**
	 * A collection of entities.
	 *
	 * @access private
	 * @var    Entity\Collection
	 */
	private $_entityCollection;

	/**
	 * Sets up the entity, allowing it to contain one or many Entity\Instance's.
	 *
	 * @access public
	 * @param  array   $data           All of the information on this entity.
	 * @param  boolean $importEntities Whether to automatically import the book's entities.
	 */
	public function __construct($data = array(), $importEntities = true) {
		$this->_entityCollection = new Entity\Collection();
		$this->import($data);

		// Do we need to import this books entities?
		if ($importEntities) {
			// Get the entities in this group
			$entities = $this->get();

			// Loop over and add to the collection
			while ($entity = $entities->fetch()) {
				$this->_entityCollection->add(new Entity\Instance($entity));
			}
		}
	}

	/**
	 * Allow scripts to iterate over the entities.
	 *
	 * @access public
	 * @return Entity\Instance
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_entityCollection->store);
	}
}