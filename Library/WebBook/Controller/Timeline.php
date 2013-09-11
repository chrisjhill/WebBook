<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

/**
 * Handles the interaction with the timeline page..
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Timeline extends Core\Controller
{
	/**
	 * Displays the overview page.
	 *
	 * @access public
	 */
	public function indexAction() {
		// Get the book
		$book = Core\Store\Request::get('book');

		// Get the entities
		$timeline = new Model\EntityGroup\Instance(array(
			'book_id'     => $book->book_id,
			'entity_type' => 'timeline'
		));

		// And setup the view
		$this->view->addVariable('timeline', $timeline);
	}
}