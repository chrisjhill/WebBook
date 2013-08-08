<?php
namespace WebBook\View\Helper\Entity;
use Core;

/**
 * Outputs the entity insert screen.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class Insert extends Core\ViewHelper
{
	/**
	 * Outputs the entity insert view.
	 *
	 * <code>
	 * array(
	 *     'entityType' => '...'
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		return $this->renderPartial('Entity/Insert', array(
			'entityType' => $params['entityType']
		));
	}
}