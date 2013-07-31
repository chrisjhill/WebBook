<?php
namespace WebBook\View\Helper\Page\Character;
use Core;

/**
 * Outputs the character to update.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class Update extends Core\ViewHelper
{
	/**
	 * Outputs the character update screen.
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
		return $this->renderPartial('Page/Character/Update', array(
			'urlRoot'       => Core\Config::get('path', 'root'),
			'entityId'      => $params['entity']->entity_id,
			'entityTitle'   => Core\Format::safeHtml($params['entity']->entity_title),
			'entityImage'   => $params['entity']->entity_image,
			'entityContent' => Core\Format::safeHtml($params['entity']->entity_content),
		));
	}
}