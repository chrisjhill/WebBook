<?php
namespace WebBook\View\Helper\Entity;
use Core;

/**
 * Outputs the entity to view.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class View extends Core\ViewHelper
{
	/**
	 * Outputs the entity view.
	 *
	 * <code>
	 * array(
	 *     'entity' => Model\Entity\Instance
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		return $this->renderPartial('Entity/View', array(
			'urlRoot'       => Core\Config::get('path', 'root'),
			'entityId'      => $params['entity']->entity_id,
			'entityType'    => $params['entity']->entity_type,
			'entityTitle'   => Core\Format::safeHtml($params['entity']->entity_title),
			'entityImage'   => $params['entity']->entity_image,
			'entityContent' => nl2br(Core\Format::safeHtml($params['entity']->entity_content)),
		));
	}
}