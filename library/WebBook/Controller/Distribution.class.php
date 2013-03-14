<?php
namespace WebBook\Controller;
use Core, WebBook\View\Helper;

/**
 * This controller handles the updating of the book privacy setting and
 * generation of the distribution code.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     13/03/2013
 */
class Distribution extends Core\Controller
{
	/**
	 * Run common functionality over the actions.
	 *
	 * @access public
	 */
	public function init() {
		$this->setLayout(false);
	}

	/**
	 * Sets up the view for distributing the book.
	 *
	 * @access public
	 * @ajax
	 */
	public function indexAction() {
		// Get the information on the book distribution
		$book = Core\StoreRequest::get('book');

		$this->view->addVariable('bookDistribution', $book->book_distribution);
		$this->view->addVariable('bookPassword', substr(
			md5($book->book_id . $book->book_created),
			0, 8
		));
	}

	/**
	 * Updates the book privacy settings.
	 *
	 * @access public
	 * @ajax
	 */
	public function updateAction() {
		// Get the book ID this is for
		$book = Core\StoreRequest::get('book');
		$book->book_distribution = Core\Request::post('book_distribution');
		$book->save();

		echo new Helper\Notice('success', 'Distribution settings have been successfully updated.');
		die();
	}
}