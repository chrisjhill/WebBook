<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

/**
 * This controller handles all of the sections.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Section extends Core\Controller
{
	/**
	 * Inserts a new section into a chapter.
	 *
	 * @access public
	 * @ajax
	 */
	public function insertAction() {
		// Get the book ID this is for
		$book = Core\Store\Request::get('book');

		// Create a new dummy section
		$section = new Model\Section\Instance(array(
			'book_id'            => $book->book_id,
			'chapter_id'         => Core\Request::post('chapter_id'),
			'section_order'      => Core\Request::post('order'),
			'section_type'       => Core\Request::post('section_type'),
			'section_content'    => Core\Request::post('section_type') == 'content'
				? '<p>Start typing&hellip;</p>'
				: 'Subtitle heading',
			'section_word_count' => 2,
			'section_created'    => Core\Request::server('REQUEST_TIME')
		));

		// And insert it
		$section->insert();

		// And echo the new section
		die($section->output());
	}

	/**
	 * Updates a single sections content.
	 *
	 * @access public
	 * @ajax
	 */
	public function updateAction() {
		// Get the information for this section
		$section = new Model\Section\Instance(array(
			'section_id' => Core\Request::post('section_id')
		));
		$section->import($section->get());

		// Update
		$section->section_order      = Core\Request::post('section_order');
		$section->section_content    = Core\Request::post('section_content');
		$section->section_word_count = str_word_count(Core\Request::post('section_content'));
		$section->section_updated    = Core\Request::server('REQUEST_TIME');
		$foo = $section->save();

		// Do not output anything
		die();
	}

	/**
	 * Reorders a group of sections within a chapter.
	 *
	 * @access public
	 * @ajax
	 */
	public function reorderAction() {
		// Not yet implemented
	}

	/**
	 * Delete a section from the chapter.
	 *
	 * @access public
	 * @ajax
	 */
	public function deleteAction() {
		// Get the book ID this is for
		$book = Core\Store\Request::get('book');

		// Get the information for this section
		$section = new Model\Section\Instance(array(
			'book_id'         => $book->book_id,
			'chapter_id'      => Core\Request::post('chapter_id'),
			'section_id'      => Core\Request::post('section_id'),
			'section_order'   => Core\Request::post('section_order'),
			'section_removed' => Core\Request::server('REQUEST_TIME')
		));
		$section->delete();

		// Do not output anything
		die();
	}
}