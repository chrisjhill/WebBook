<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

/**
 * Handles the interaction with the snapshot page.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Snapshot extends Core\Controller
{
	/**
	 * Generates the snapshot information.
	 *
	 * @access public
	 * @ajax
	 */
	public function indexAction() {
		// The book and user information
		$book = Core\StoreRequest::get('book');
		$user = Core\StoreRequest::get('user');

		// Get the snapshot information
		$snapshot = new Model\snapshot\Instance(array(
			'book_id' => $book->book_id
		));
		$snapshot->setData();

		// And set the variables the View Script will need
		$this->view->addVariable('bookId',        $book->book_id);
		$this->view->addVariable('bookSnapshots', $snapshot);
	}

	/**
	 * Update the users target.
	 *
	 * @access public
	 * @ajax
	 */
	public function updateAction() {
		// @todo Check that the fields are valid

		// Update settings instance
		$book = Core\StoreRequest::get('book');

		// Set the new target information and save
		$target = new Model\Target\Instance($book->book_id);
		$target->target_word_count = Core\Request::post('target_word_count');
		$target->target_date       = strtotime(Core\Request::post('target_date'));
		$target->save();

		// Display notice
		echo new Helper\Notice('success', 'Target has been successfully updated.');
		die();
	}
}