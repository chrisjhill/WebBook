<?php
namespace WebBook\Model\Chapter;
use Core, WebBook\Model\Section;

/**
 * Contains information on a chapter.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.2
 * @since     22/10/2012
 *
 * @todo Needs a setInfo() function.
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
	 * Setup a chapter.
	 *
	 * @access public
	 */
	public function __construct($bookId = 1, $chapterId = 1) {
		// Create a collection of sections
		$this->_sectionCollection = new Section\Collection();

		// Get the sections in this chapter
		$this->book_id    = $bookId;
		$this->chapter_id = $chapterId;
		$sections         = $this->getAllSections();

		// Loop over each section and add the instance
		while ($section = $sections->fetch()) {
			$this->_sectionCollection->add(new Section\Instance($section));
		}
	}

	/**
	 * Allow scripts to iterate over the sections.
	 *
	 * @access public
	 * @return Instance
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_sectionCollection->store);
	}
}