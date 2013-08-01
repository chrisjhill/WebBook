<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

/**
 * This controller handles the output of the location overview page.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Location extends Core\Controller
{
	/**
	 * View the location overview page.
	 *
	 * @access public
	 */
	public function indexAction() {
		// Get the book
		$book = Core\Store\Request::get('book');

		// Get the entities
		$locations = new Model\EntityGroup\Instance(array(
			'book_id'     => $book->book_id,
			'entity_type' => 'location'
		));

		// And setup the view
		$this->view->addVariable('locations', $locations);
	}
}