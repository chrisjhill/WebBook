<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

/**
 * This controller handles the output of the character overview page.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Character extends Core\Controller
{
	/**
	 * View the character overview page.
	 *
	 * @access public
	 */
	public function indexAction() {
		// Get the book
		$book = Core\StoreRequest::get('book');

		// Get the entities
		$characters = new Model\EntityGroup\Instance(array(
			'book_id'     => $book->book_id,
			'entity_type' => 'character'
		));

		// And setup the view
		$this->view->addVariable('characters', $characters);
	}
}