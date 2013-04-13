<?php
namespace WebBook\Controller;
use Core;

/**
 * The public aspect of the site.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 */
class Index extends Core\Controller
{
	/**
	 * Provides common functionality to this controllers actions.
	 *
	 * @access public
	 */
	public function init() {
		// We set the layout to default here because we may have been redirected.
		$this->setLayout('default');
	}

	/**
	 * The first page of the site.
	 *
	 * @access public
	 */
	public function indexAction() {
		// Do nothing
	}
}