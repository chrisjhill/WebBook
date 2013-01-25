<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

class Book extends Core\Controller
{
	/**
	 * This function is called on each load on this controller.
	 *
	 * @access public
	 */
	public function init() {
		// Set variables
		$this->view->addVariable('book', Core\StoreRequest::get('book'));
		$this->view->addVariable('user', Core\StoreRequest::get('user'));
	}

	/**
	 * Allowing a book to be edited by the user.
	 *
	 * @access public
	 */
	public function editAction() {
		// Do nothing
	}

	/**
	 * Output the book.
	 *
	 * @access public
	 * @ajax
	 */
	public function pageAction() {
		// Get the book
		$book = Core\StoreRequest::get('book');

		// And loop over each chapter and section
		echo '<div class="container">';

		foreach ($book as $chapter) {
			echo '
				<div class="chapter"
					id="chapter-<?=$chapter->chapter_id?>"
					name="chapter-<?=$chapter->chapter_id?>"
					data-chapterid="<?=$chapter->chapter_id?>">';

			foreach ($chapter as $section) {
				echo $section->output();
			}

			echo '</div>';
		}

		echo '
			</div>

			<div id="section-insert">
				<p>
					<a href="#" class="section-insert-link" id="section-insert-title" data-sectionid="0">title +</a><br />
					<a href="#" class="section-insert-link" id="section-insert-content" data-sectionid="0">content +</a><br />
					<a href="#" class="section-insert-link" id="section-insert-delete" data-sectionid="0">delete &ndash;</a><br />
				</p>
			</div>';
		die();
	}

	/**
	 * The error action.
	 *
	 * @access public
	 */
	public function errorAction() {
		// Do nothing
	}
}