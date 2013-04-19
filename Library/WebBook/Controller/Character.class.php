<?php
namespace WebBook\Controller;
use Core, WebBook\Model, WebBook\View\Helper;

/**
 * Handles the interaction with the characters.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Character extends Core\Controller
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

		// Get the characters in the book
		$this->view->addVariable('characters', true);
	}

	/**
	 * Insert a new character.
	 *
	 * @access public
	 * @ajax
	 */
	public function insertAction() {
		// Set the new character's information
		$character = new Model\Character\Instance(array(
			'book'           => Core\Request::post('book'),
			'entity_type'    => 'character',
			'entity_title'   => Core\Request::post('book'),
			'entity_image'   => Core\Request::post('book'),
			'entity_content' => Core\Request::post('book'),
			'entity_content' => Core\Request::server('REQUEST_TIME')
		));
		$character->save();

		// Output when the snapshot was created
		die($character->output());
	}

	/**
	 * Update a character.
	 *
	 * @access public
	 * @ajax
	 */
	public function updateAction() {
		// Set the new character's information
		$character = new Model\Character\Instance(array(
			'book_id'        => Core\Request::post('book'),
			'character_id'   => Core\Request::post('character_id'),
			'entity_type'    => 'character',
			'entity_title'   => Core\Request::post('book'),
			'entity_image'   => Core\Request::post('book'),
			'entity_content' => Core\Request::post('book'),
			'entity_content' => Core\Request::server('REQUEST_TIME')
		));
		$character->save();

		// Output when the snapshot was created
		echo new Helper\Notice('success', 'Character information has been successfully updated.');
		die();
	}

	/**
	 * Remove a character.
	 *
	 * @access public
	 * @ajax
	 */
	public function removeAction() {
		// Set the character and then remove
		$character = new Model\Character\Instance(array(
			'book_id'   => Core\Request::post('book'),
			'entity_id' => Core\Request::post('entity_id')
		));
		$character->delete();

		// Display notice
		echo new Helper\Notice('success', 'Character has been successfully removed.');
		die();
	}
}