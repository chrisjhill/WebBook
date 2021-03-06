<?php
namespace WebBook\View\Helper\Entity;
use Core;

/**
 * Outputs the entity overview view.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class Overview extends Core\ViewHelper
{
	/**
	 * Outputs the entity overview view.
	 *
	 * <code>
	 * array(
	 *     'entityType' => '...',
	 *     'entities'   => Model\EntityGroup\Instance
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		// There might be several entity groups
		$entityGroup      = array();
		$entityGroupTitle = array();
		$entityGroupHtml  = '';
		$entityReturnHtml = '';

		// Loop over each entity and add them to their respective group
		foreach ($params['entities'] as $entityId => $entity) {
			// Set the title for this group
			$entityGroupTitle[$entity->entity_id] = $entity->group_title;

			// Get the entity HTML
			$entityGroup[$entity->entity_group_id][$entity->entity_id] =
				$this->renderPartial('Entity/Item', array(
					'urlRoot'       => $this->view->getVariable('urlRoot'),
					'entityId'      => $entity->entity_id,
					'entityType'    => $entity->entity_type,
					'entityGroupId' => $entity->entity_group_id,
					'entityImage'   => $entity->entity_image,
					'entityTitle'   => $entity->entity_title
				));
		}

		// Loop over each entity group
		foreach ($entityGroup as $entityGroupId => $entities) {
			// A new entity group, reset the HTML
			$entityGroupHtml = '';

			// Loop over each entity within this entity group
			foreach ($entities as $entityId => $entityHtml) {
				// Group together all of the HTML of the entities in this group
				$entityGroupHtml .= $entityHtml;
			}

			// We have all the entities in this group, generate the containing HTML
			$entityReturnHtml .= $this->renderPartial('Entity/Group', array(
				'entityGroupId'    => $entityGroupId,
				'entityType'       => $params['entityType'],
				'entityGroupTitle' => $entityGroupTitle[$entityId],
				'entityGroupHtml'  => $entityGroupHtml,
				'canUpdate'        => true
			));
		}

		// And add the 'new group' HTML
		$entityReturnHtml .= $this->renderPartial('Entity/Group', array(
			'entityGroupId'    => 0,
			'entityType'       => $params['entityType'],
			'entityGroupTitle' => 'New ' . $params['entityType'] . ' group',
			'entityGroupHtml'  => '',
			'canUpdate'        => false
		));

		// And return the group HTML
		return $entityReturnHtml;
	}
}