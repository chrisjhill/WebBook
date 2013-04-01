<?php
namespace WebBook\Controller;
use Core, WebBook\Model, WebBook\View\Helper;

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
	 * Save a snapshot.
	 *
	 * @access public
	 * @ajax
	 */
	public function saveAction() {
		// Set the new snapshot information and remove
		$snapshot = new Model\Snapshot\Instance(array(
			'book'             => Core\StoreRequest::get('book'),
			'snapshot_created' => Core\Request::server('REQUEST_TIME')
		));
		$snapshot->save();

		// Output when the snapshot was created
		echo Core\Request::server('REQUEST_TIME');
		die();
	}

	/**
	 * Remove a snapshot.
	 *
	 * @access public
	 * @ajax
	 */
	public function removeAction() {
		// Set the new snapshot information and remove
		$snapshot = new Model\Snapshot\Instance(array(
			'book_id'          => Core\Request::post('book_id'),
			'snapshot_created' => Core\Request::post('snapshot_id')
		));
		$snapshot->delete();

		// Display notice
		echo new Helper\Notice('success', 'Snapshot has been successfully removed.');
		die();
	}
}