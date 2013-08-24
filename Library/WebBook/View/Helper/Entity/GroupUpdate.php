<?php
namespace WebBook\View\Helper\Entity;
use Core;

/**
 * Outputs the entity group to update.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class GroupUpdate extends Core\ViewHelper
{
	/**
	 * Outputs the entity group update screen.
	 *
	 * <code>
	 * array(
	 *     'entityGroup' => Model\EntityGroup\Instance
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		return $this->renderPartial('Entity/GroupUpdate', array(
			'urlRoot'       => Core\Config::get('path', 'root'),
			'entityGroupId' => $params['entityGroup']['entity_group_id'],
			'groupTitle'    => Core\Format::safeHtml($params['entityGroup']['group_title'])
		));
	}
}