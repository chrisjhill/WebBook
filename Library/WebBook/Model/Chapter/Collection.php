<?php
namespace WebBook\Model\Chapter;

/**
 * A list of chapters in a book.
 *
 * @copyright   2013 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class Collection implements \IteratorAggregate
{
	/**
	 * An array of the chapters.
	 *
	 * @access public
	 * @var    array   An collection of Chapter\Instance's
	 */
	public $store = array();

	/**
	 * Add a section to this list.
	 *
	 * @access public
	 * @param  Section\Instance $section A section to add to this chapter.
	 * @throws Exception                 If Section\Instance is not passed in.
	 */
	public function add($section) {
		if (get_class($section) != 'WebBook\Model\Section\Instance') {
			throw new \Exception('Expecting a Section class.');
		}

		// Does the chapter already exist?
		if (! isset($this->store[$section->chapter_id])) {
			// Create chapter instance
			$this->store[$section->chapter_id] = new Instance();
		}

		// And add to the store
		$this->store[$section->chapter_id]->add($section);
	}

	/**
	 * Allow scripts to iterate over the chapters.
	 *
	 * @access public
	 * @return Chapter\Instance
	 */
	public function getIterator() {
		return new \ArrayIterator($this->store);
	}
}