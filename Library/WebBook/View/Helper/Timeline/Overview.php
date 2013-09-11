<?php
namespace WebBook\View\Helper\Timeline;
use Core;

/**
 * Produces output for the timeline.
 *
 * @copyright 2013 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Overview extends Core\ViewHelper
{
	/**
	 * Render the waterfall profiler.
	 *
	 * <code>
	 * array(
	 *     'entities' => Model\EntityGroup\Instance
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params The data that we received from the Core\Profiler.
	 * @return string
	 */
	public function render($params) {
		// COntainer for the timeline output
		$timelineHtml = '';

		// Loop over each entity and add them to their respective group
		foreach ($params['entities'] as $entityId => $entity) {
			$timelineHtml .= $this->renderPartial('Timeline/Event', array(
				'urlRoot'       => $this->view->getVariable('urlRoot'),
				'entityId'      => $entity->entity_id,
				'entityType'    => $entity->entity_type,
				'entityImage'   => $entity->entity_image,
				'entityTitle'   => $entity->entity_title,
				'entityContent' => $entity->entity_content
			));
		}

		return $timelineHtml;
	}
}