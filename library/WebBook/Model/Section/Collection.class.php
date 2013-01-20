<?php
namespace WebBook\Model\Section;
use Core;

/**
 * A list of chapters in a book.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @since       20/01/2013
 */
class Collection implements \IteratorAggregate
{
	/**
	 * An array of the chapters.
	 *
	 * @access private
	 * @var    array   An collection of Model\Chapter's
	 */
	private $_chapter = array();

	/**
	 * Add a chapter to this list.
	 *
	 * @access public
	 * @param  Model\Chapter $chapter A chapter to add to this book.
	 * @throws Exception              If Model\Chapter is not passed in.
	 */
	public function add($chapter) {
		if (get_class($chapter) != 'Chapter') {
			throw new Exception('Expecting a Chapter class.');
		}

		$this->_chapter[$chapter->getInfo('chapter_id')] = $chapter;
	}

	/**
	 * Return a chapter.
	 *
	 * @access public
	 * @param  int           $chapterId The chapter that we wish to return.
	 * @return Model\Chapter
	 */
	public function get($chapterId) {
		if (! isset($this->_chapter[chapterId])) {
			throw new Exception('Chapter does not exist.');
		}

		return $this->_chapter[chapterId];
	}

	/**
	 * Allow scripts to iterate over the chapters.
	 *
	 * @access public
	 * @return Model\Chapter
	 */
	public function getIterator() {
		return new ArrayIterator($this->_chapter);
	}
}