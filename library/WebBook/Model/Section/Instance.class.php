<?php
namespace WebBook\Model\Section;
use Core;

/**
 * Contains information on a section in a chapter.
 *
 * @copyright 2012 Christopher Hill <cjhill@gmail.com>
 * @author    Christopher Hill <cjhill@gmail.com>
 * @version   0.2
 * @since     20/01/2013
 */
class Instance extends Repository
{
	/**
	 * Create a new Section\Instance.
	 *
	 * @access public
	 * @param  array  $data All of the information on this section.
	 */
	public function __construct($data = array()) {
		$this->import($data);
	}
}