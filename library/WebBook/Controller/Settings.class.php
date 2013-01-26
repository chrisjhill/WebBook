<?php
namespace WebBook\Controller;
use Core, WebBook\Utility;

/**
 * This controller handles all of the settings actions.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.1
 * @since     26/01/2013
 */
class Settings extends Core\Controller
{
	/**
	 * This function is called on each load on this controller.
	 *
	 * It's job is to provide a consistent environment for the rest of the actions.
	 *
	 * @access public
	 */
	public function init() {
		$this->setLayout(false);
		$this->view->addVariable('book',     Core\StoreRequest::get('book'));
		$this->view->addVariable('user',     Core\StoreRequest::get('user'));
		$this->view->addVariable('settings', Core\StoreRequest::get('settings'));
	}

	/**
	 * Displays the settings page ready for the user to update.
	 *
	 * @access public
	 * @ajax
	 */
	public function indexAction() {
		// Do nothing
	}

	/**
	 * Allowing a book to be edited by the user.
	 *
	 * @access public
	 * @ajax
	 */
	public function updateAction() {
		// @todo Check that the fields are valid

		// Update settings instance
		$settings = $this->view->getVariable('settings');
		$book     = $this->view->getVariable('book');

		$settings->import(array(
			'book_id'                  => $book->book_id,
			'setting_autosave'         => Core\Request::post('setting_autosave'),
			'setting_font_family'      => Core\Request::post('setting_font_family'),
			'setting_font_size'        => Core\Request::post('setting_font_size'),
			'setting_font_color'       => Core\Request::post('setting_font_color'),
			'setting_line_height'      => Core\Request::post('setting_line_height'),
			'setting_alignment'        => Core\Request::post('setting_alignment'),
			'setting_background'       => Core\Request::post('setting_background'),
			'setting_page_paddings'    => Core\Request::post('setting_page_paddings'),
			'setting_display_comments' => Core\Request::post('setting_display_comments')
		));

		$settings->save();

		// Display notice
		echo new Utility\Notice('success', 'Settings have been successfully updated.');
		die();
	}
}