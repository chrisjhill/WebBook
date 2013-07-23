<?php
namespace WebBook\Controller;
use Core, WebBook\Utility, WebBook\View\Helper;

/**
 * This controller handles the updating of the book privacy setting and
 * generation of the distribution code.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Distribution extends Core\Controller
{
	/**
	 * Sets up the view for distributing the book.
	 *
	 * @access public
	 * @ajax
	 */
	public function indexAction() {
		// Get the information on the book distribution
		$book = Core\Store\Request::get('book');

		$this->view->addVariable('urlBookView',      Utility\Url::bookView($book));
		$this->view->addVariable('bookDistribution', $book->book_distribution);
	}

	/**
	 * Updates the book privacy settings.
	 *
	 * @access public
	 * @ajax
	 */
	public function updateAction() {
		// Get the book ID this is for
		$book = Core\Store\Request::get('book');
		$book->book_distribution = Core\Request::post('book_distribution');
		$book->save();

		echo new Helper\Notice('success', 'Distribution settings have been successfully updated.');
		die();
	}
}