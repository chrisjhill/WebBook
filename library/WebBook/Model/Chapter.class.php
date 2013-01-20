<?php
namespace WebBook\Model;
use Core;

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
class Chapter
{
	/**
	 * Information on the book.
	 *
	 * @access private
	 * @var    array
	 */
	private $_store = array();

	/**
	 * Creates a single chapter.
	 *
	 * @access public
	 * @param  int    $chapterId The chapter ID that we wish to load.
	 * @param  int    $bookId    The book ID that the chapter belongs to.
	 */
	public function __construct($chapterId, $bookId) {
		$this->setInfo($bookId);
	}

	/**
	 * Delete a chapter.
	 *
	 * @access public
	 * @return boolean If the removal was successful.
	 */
	public function remove() {
		// Get PDO
		$pdo = Model_Database::getPdoConnection();

		// Set query string
		$query = Database::get()->prepare("
			UPDATE `section` s
			SET	s.section_removed = :section_removed
			WHERE  s.book_id      = :book_id
				   AND
				   s.chapter_id	  = :chapter_id
		");

		// And execute query
		$query->execute(array(
			':book_id'		 => $param['book']->getInfo('book_id'),
			':chapter_id'	  => $param['chapter_id'],
			':section_removed' => $_SERVER['REQUEST_TIME']
		));
	}
}