<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

/**
 * This controller handles all of the chapter interactions.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Chapter extends Core\Controller
{
	/**
	 * View the chapter overview page.
	 *
	 * @access public
	 */
	public function indexAction() {
		// Do nothing
	}

	/**
	 * Inserts a new chapter into a book.
	 *
	 * @access public
	 * @ajax
	 */
	public function insertAction() {
		// Get the book ID this is for
		$book = Core\Store\Request::get('book');

		// Increment the chapter ID's
		$chapter = new Model\Chapter\Instance(array(
			'book_id'    => $book->book_id,
			'chapter_id' => Core\Request::post('chapter_id')
		));
		$chapter->incrementOrder();

		// Create a new dummy chapter title
		$section = new Model\Section\Instance(array(
			'book_id'            => $book->book_id,
			'chapter_id'         => Core\Request::post('chapter_id'),
			'section_order'      => 0,
			'section_type'       => 'chaptertitle',
			'section_content'    => 'Your chapter title',
			'section_word_count' => 3,
			'section_created'    => Core\Request::server('REQUEST_TIME')
		));

		// And insert the chapter title
		$section->insert();
		$chapter->add($section);

		// Create a new dummy chapter title
		$section = new Model\Section\Instance(array(
			'book_id'            => $book->book_id,
			'chapter_id'         => Core\Request::post('chapter_id'),
			'section_order'      => 1,
			'section_type'       => 'content',
			'section_content'    => '<p>Click here to start writing&hellip;</p>',
			'section_word_count' => 5,
			'section_created'    => Core\Request::server('REQUEST_TIME')
		));

		// And insert the chapter title
		$section->insert();
		$chapter->add($section);

		// And output
		echo $this->view->book_Chapter(array(
			'chapter'          => $chapter,
			'chapterId'        => Core\Request::post('chapter_id'),
			'chapterCanRemove' => true
		));

		// Do not output anything
		die();
	}

	/**
	 * Delete a chapter from the book.
	 *
	 * @access public
	 * @ajax
	 */
	public function deleteAction() {
		// Get the book ID this is for
		$book = Core\Store\Request::get('book');

		// Create instance from the post information
		$section = new Model\Chapter\Instance(array(
			'book_id'         => $book->book_id,
			'chapter_id'      => Core\Request::post('chapter_id'),
			'section_removed' => Core\Request::server('REQUEST_TIME')
		));

		// Delete the chapter
		$section->delete();

		// Do not output anything
		die();
	}
}