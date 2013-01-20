<?php
namespace WebBook\Model;
use Core;

/**
 * Contains information on a single book.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     22/10/2012
 */
class Book
{
	/**
	 * Information on the book.
	 *
	 * @access private
	 * @var    array
	 */
	private $_store = array();

	/**
	 * Each chapter in this book.
	 *
	 * @access private
	 * @var    Model\ChapterList
	 */
	private $_chapterList;

	/**
	 * Initialise the book.
	 *
	 * @access public
	 * @param  int    $bookId The ID of the book we wish to load.
	 */
	public function __construct($bookId) {
		$this->_chapterList = new Chapter\Collection();
		$this->setInfo($bookId);
	}

	/**
	 * Get the book for a logged in user.
	 *
	 * @access private
	 * @param  int       $bookId The ID of the book we wish to load.
	 * @throws Exception         If the book cannot be found.
	 */
	private function setInfo($bookId) {
		// Set query string
		$query = Database::get()->prepare("
			SELECT b.book_id, b.user_id, b.book_title, b.book_distribution, b.book_created, b.book_updated, b.book_removed,
				   (
					   SELECT SUM(s.section_word_count)
					   FROM   `section` s
					   WHERE  s.book_id		 = :book_id
							  AND
							  s.section_removed = 0
				   ) as 'book_word_count'
			FROM   `book` b
			WHERE  b.book_id = :book_id
			LIMIT  1
		");

		// And execute
		$query->execute(array(
			':book_id' => $bookId
		));

		// Could we find the book?
		if ($query->rowCount() <= 0) {
			throw new Exception('Book not found.');
		}

		// Set all of the information
		$this->_store = $query->fetch();
	}

	/**
	 * Returns a piece of information on the book.
	 *
	 * @access public
	 * @param  string $variable The piece of data we want on the book.
	 * @param  string $default  If we cannot find the piece of data, this is returned.
	 * @return mixed
	 */
	public function getInfo($variable, $default = null) {
		return isset($this->_store[$variable])
			? $this->_store[$variable]
			: $default;
	}

	/**
	 * Get the book password.
	 *
	 * @access public
	 * @return string
	 */
	public function getPassword() {
		return substr(
			md5($this->getInfo('book_id') . $this->getInfo('book_created')),
			0, 8
		);
	}
}