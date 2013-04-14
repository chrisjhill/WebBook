<?php
namespace WebBook\Model\Book;
use Core, WebBook\Model\Chapter, WebBook\Model\Section;

/**
 * Contains information on a book.
 *
 * A book can contain one or many chapters. A chapter can contain one or many
 * sections. A section is a piece of content, such as a title or paragraph.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Instance extends Repository implements \IteratorAggregate
{
	/**
	 * A collection of chapters.
	 *
	 * @access private
	 * @var    Chapter\Collection
	 */
	private $_chapterCollection;

	/**
	 * Setup a book.
	 *
	 * @access public
	 * @param  int    $bookId     The book that we wish to setup.
	 * @param  int    $snapshotId The ID of the snapshot that has been taken.
	 */
	public function __construct($bookId, $snapshotId) {
		// Create a collection of chapters
		$this->_chapterCollection = new Chapter\Collection();

		// Make sure that the book ID is not boolean true
		// Note: It can be true if the URL is /book/edit/id
		if ($bookId === true) {
			return false;
		}

		// Get the sections in this chapter
		$this->book_id = $bookId;
		$this->snapshot_created = $snapshotId;
		$sections = $snapshotId
			? $this->getAllSectionsFromSnapshot()
			: $this->getAllSections();

		// Import the book information
		$this->import($this->get());
		$this->book_word_count = 0;

		// Loop over each section and add the instance
		while ($section = $sections->fetch()) {
			$this->_chapterCollection->add(new Section\Instance($section));
			$this->book_word_count += $section['section_word_count'];
		}
	}

	/**
	 * Allow scripts to iterate over the sections.
	 *
	 * @access public
	 * @return Chapter\Instance
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_chapterCollection->store);
	}
}