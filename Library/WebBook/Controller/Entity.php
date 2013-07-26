<?php
namespace WebBook\Controller;
use Core, WebBook\Model, WebBook\View\Helper;

/**
 * Handles the interaction with entities.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Entity extends Core\Controller
{
	/**
	 * Insert a new entity.
	 *
	 * @access public
	 * @ajax
	 */
	public function insertAction() {
		// Set the new entities information
		$entity = new Model\Entity\Instance(array(
			'book_id'         => Core\Request::post('book_id'),
			'entity_group_id' => Core\Request::post('entity_group_id'),
			'entity_type'     => Core\Request::post('entity_type'),
			'entity_title'    => Core\Request::post('entity_title'),
			'entity_image'    => Core\Request::post('entity_image'),
			'entity_content'  => Core\Request::post('entity_content'),
			'entity_created'  => Core\Request::server('REQUEST_TIME')
		));
		$entity->save();

		// Output the entities HTML
		die($entity->output());
	}

	/**
	 * Return the information on an entity.
	 *
	 * @access public
	 */
	public function getAction() {
		// Get the entity
		$entity = new Model\Entity\Instance(array(
			'book_id'   => Core\Request::post('book_id'),
			'entity_id' => Core\Request::post('entity_id')
		));

		// Display an update form or is the user just viewing the entity?
		if (Core\Request::post('book_id') == 'update') {
			// Display update form
		} else {
			// Just display the entity information
		}
	}

	/**
	 * Update an entity.
	 *
	 * @access public
	 * @ajax
	 */
	public function updateAction() {
		// Update the entities information
		$entity = new Model\Entity\Instance(array(
			'book_id'         => Core\Request::post('book_id'),
			'entity_group_id' => Core\Request::post('entity_group_id'),
			'entity_type'     => Core\Request::post('entity_type'),
			'entity_title'    => Core\Request::post('entity_title'),
			'entity_image'    => Core\Request::post('entity_image'),
			'entity_content'  => Core\Request::post('entity_content'),
			'entity_created'  => Core\Request::server('REQUEST_TIME')
		));
		$entity->save();

		// Output when the snapshot was created
		echo new Helper\Notice('success', 'Entities information has been successfully updated.');
		die();
	}

	/**
	 * Remove an entity.
	 *
	 * @access public
	 * @ajax
	 */
	public function removeAction() {
		// Set the entity and then remove
		$entity = new Model\Entity\Instance(array(
			'book_id'   => Core\Request::post('book'),
			'entity_id' => Core\Request::post('entity_id')
		));
		$entity->delete();

		// Display notice
		echo new Helper\Notice('success', 'Entity has been successfully removed.');
		die();
	}
}