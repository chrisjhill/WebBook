<?php
namespace WebBook\Model\Settings;

/**
 * Contains information on the book settings.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     22/10/2012
 */
class Instance extends Repository
{
	/**
	 * Get the settings on this book.
	 *
	 * @access public
	 * @param  int    $bookId The book that we want to get the settings for.
	 */
	public function __construct($bookId) {
		$this->book_id = $bookId;
		$this->setData();
	}

	/**
	 * Get the settings and import them into the store.
	 *
	 * @access public
	 */
	public function setData() {
		$this->import($this->get());
	}
}