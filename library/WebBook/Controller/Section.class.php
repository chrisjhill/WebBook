<?php
namespace WebBook\Controller;
use Core, WebBook\Model;

/**
 * This controller handles all of the sections.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     02/03/2013
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
		$this->setLayout(false);
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
		// @todo str_word_count() might not be the most appropriate function.
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
		$this->setLayout(false);
	}

	/**
	 * Delete a section from the chapter.
	 *
	 * @access public
	 * @ajax
	 */
	public function deleteAction() {
		// Get the information for this section
		$section = new Model\Section\Instance(array(
			'section_id' => Core\Request::post('section_id')
		));
		$section->delete();

		// Do not output anything
		die();
	}
}