<?php
namespace WebBook\Model\Target;
use WebBook\View\Helper;

/**
 * Contains information on the target the user has set.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Instance extends Repository
{
	/**
	 * Create a new Target\Instance.
	 *
	 * @access public
	 * @param  string $book_id The ID of the book.
	 */
	public function __construct($bookId) {
		$this->book_id = $bookId;
		$this->setData();
	}

	/**
	 * Get the target that the user has set.
	 *
	 * @access public
	 */
	public function setData() {
		$this->import($this->get());
	}
}