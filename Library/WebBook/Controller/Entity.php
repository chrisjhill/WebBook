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
	 * Prepare the view for inserting a new entity.
	 *
	 * @access public
	 * @ajax
	 */
	public function insertViewAction() {
		die($this->view->Entity_Insert(array(
			'entityType' => Core\Request::post('entity_type')
		)));
	}

	/**
	 * Insert a new entity.
	 *
	 * @access public
	 * @ajax
	 */
	public function insertAction() {
		// Do we need to create a new group first?
		$entityGroupId = null;
		if (Core\Request::post('entity_group_id') == '0') {
			$entityGroup = new Model\EntityGroup\Instance(array(
				'book_id'       => Core\Request::post('book_id'),
				'group_title'   => 'New character group',
				'group_created' => Core\Request::server('REQUEST_TIME')
			), false);
			$entityGroupId = $entityGroup->save();
		}

		// Set the new entities information
		$entity = new Model\Entity\Instance(array(
			'book_id'         => Core\Request::post('book_id'),
			'entity_group_id' => $entityGroupId ?: Core\Request::post('entity_group_id'),
			'entity_type'     => Core\Request::post('entity_type'),
			'entity_title'    => Core\Request::post('entity_title'),
			'entity_image'    => Core\Request::post('entity_image'),
			'entity_content'  => Core\Request::post('entity_content'),
			'entity_created'  => Core\Request::server('REQUEST_TIME')
		));
		$entity->save();

		// Output the success notice
		echo new Helper\Notice(
			'success',
			ucfirst(Core\Request::post('entity_type')) . ' has been successfully saved.'
		);
		die();
	}

	/**
	 * Return the information on an entity.
	 *
	 * @access public
	 * @ajax
	 */
	public function getAction() {
		// Get the entity
		$entity = new Model\Entity\Instance(array(
			'book_id'   => Core\Request::post('book_id'),
			'entity_id' => Core\Request::post('entity_id')
		));
		$entity->get();

		// Display an update form or is the user just viewing the entity?
		if (Core\Request::post('action') == 'update') {
			// Display update form
			die($this->view->Entity_Update(array('entity' => $entity)));
		} else {
			// Just display the entity information
			die($this->view->Entity_View(array('entity' => $entity)));
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
			'entity_id'       => Core\Request::post('entity_id'),
			'entity_group_id' => Core\Request::post('entity_group_id'),
			'entity_type'     => Core\Request::post('entity_type'),
			'entity_title'    => Core\Request::post('entity_title'),
			'entity_image'    => Core\Request::post('entity_image'),
			'entity_content'  => Core\Request::post('entity_content'),
			'entity_updated'  => Core\Request::server('REQUEST_TIME')
		));
		$entity->save();

		// Output when the snapshot was created
		echo new Helper\Notice(
			'success',
			ucfirst(Core\Request::post('entity_type')) . ' information has been successfully updated.'
		);
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
			'book_id'        => Core\Request::post('book_id'),
			'entity_id'      => Core\Request::post('entity_id'),
			'entity_removed' => Core\Request::server('REQUEST_TIME')
		));
		$entity->delete();

		// Display notice
		echo new Helper\Notice(
			'success',
			ucfirst(Core\Request::post('entity_type')) . ' has been successfully removed.'
		);
		die();
	}

	/**
	 * Display a group ready for updating.
	 *
	 * @access public
	 * @ajax
	 */
	public function groupAction() {
		// Get the entity group
		$entityGroup = new Model\EntityGroup\Instance(array(
			'book_id'         => Core\Request::post('book_id'),
			'entity_group_id' => Core\Request::post('entity_group_id')
		), false);
		$entityGroup = $entityGroup->getEntityGroup();

		// Output the updateentity group form
		die($this->view->Entity_GroupUpdate(array('entityGroup' => $entityGroup)));
	}

	/**
	 * Updates an entity group.
	 *
	 * @access public
	 * @ajax
	 */
	public function groupUpdateAction() {
		// Get the entity group
		$entityGroup = new Model\EntityGroup\Instance(array(
			'book_id'         => Core\Request::post('book_id'),
			'entity_group_id' => Core\Request::post('entity_group_id'),
			'group_updated'   => Core\Request::server('REQUEST_TIME')
		), false);

		// Update the title and save
		$entityGroup->group_title = Core\Request::post('group_title');
		$entityGroup->save();

		// Display notice
		echo new Helper\Notice('success', 'Group has been successfully updated.');
		die();
	}
}