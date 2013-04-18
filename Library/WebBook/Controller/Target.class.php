<?php
namespace WebBook\Controller;
use Core, WebBook\Model, WebBook\View\Helper;

/**
 * Handles the interaction with the target page.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Target extends Core\Controller
{
	/**
	 * Generates the target and progress information.
	 *
	 * @access public
	 * @ajax
	 */
	public function indexAction() {
		// The book information
		$book = Core\StoreRequest::get('book');

		// Get the target the user has made
		$target = new Model\Target\Instance($book->book_id);

		// Get the books progressions
		$progress = new Model\Progress\Instance(array(
			'book_id' => $book->book_id
		));
		$progress->setData();

		// Work out the percentage complete
		// User hasn't event started yet
		if ($book->book_word_count == 0) {
			$bookPercentComplete = 0;
		}

		// We have met our target
		else if ($target->target_word_count <= $book->book_word_count) {
			$bookPercentComplete = 100;
		}

		// Has started, but has not met their target
		else {
			$bookPercentComplete = number_format(
				($book->book_word_count / $target->target_word_count) * 100, 1
			);
		}

		// And set the variables the View Script will need
		$this->view->addVariable('bookWordCount',       number_format($book->book_word_count), 2);
		$this->view->addVariable('bookTargetWordCount', number_format($target->target_word_count), 2);
		$this->view->addVariable('bookTargetDate',      date('jS F, Y', $target->target_date));
		$this->view->addVariable('bookPercentComplete', $bookPercentComplete);
		$this->view->addVariable('bookProgressMarkers', $progress);
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