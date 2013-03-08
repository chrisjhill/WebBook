<?php
namespace WebBook\Model\Chapter;
use WebBook\Model\Section;

/**
 * Contains information on a chapter.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.2
 * @since     22/10/2012
 */
class Instance extends Repository implements \IteratorAggregate
{
	/**
	 * A collection of sections.
	 *
	 * @access private
	 * @var    Section\Collection
	 */
	private $_sectionCollection;

	/**
	 * Sets up the chapter, allowing it to contain one or many Section\Instance's.
	 *
	 * @access public
	 * @param  array  $data All of the information on this section.
	 */
	public function __construct($data = array()) {
		$this->_sectionCollection = new Section\Collection();
		$this->import($data);
	}

	/**
	 * Add a section to this collection.
	 *
	 * @access public
	 * @param  Section\Instance $section A section to add to this chapter.
	 * @throws Exception                 If Section\Instance is not passed in.
	 */
	public function add($section) {
		if (get_class($section) != 'WebBook\Model\Section\Instance') {
			throw new \Exception('Expecting a Section class.');
		}

		$this->_sectionCollection->add($section);
	}

	/**
	 * Allow scripts to iterate over the sections.
	 *
	 * @access public
	 * @return Section\Instance
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_sectionCollection->store);
	}
}